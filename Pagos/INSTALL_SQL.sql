-- ====================================================================
-- INSTALACIÓN: Sistema de Solicitudes de Pago
-- NachoTechRD - Integrado con sistema existente
-- ====================================================================

-- Tabla de solicitudes de pago pendientes
CREATE TABLE IF NOT EXISTS `gsm_payment_requests` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  `MemberID` INT(11) DEFAULT NULL COMMENT 'ID del miembro (si existe en gsm_members)',
  `UserName` VARCHAR(255) NOT NULL COMMENT 'Nombre completo del usuario',
  `UserEmail` VARCHAR(255) NOT NULL COMMENT 'Email de contacto',
  `ServerEmail` VARCHAR(255) DEFAULT NULL COMMENT 'Email del servidor/cuenta',
  `Amount` DECIMAL(10,2) NOT NULL COMMENT 'Monto en USD',
  `PaymentMethod` VARCHAR(100) NOT NULL COMMENT 'Método de pago usado',
  `TransactionRef` VARCHAR(255) DEFAULT NULL COMMENT 'Referencia/ID de transacción',
  `AdditionalInfo` TEXT DEFAULT NULL COMMENT 'Información adicional',
  `Status` ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending' COMMENT 'Estado de la solicitud',
  `AdminNotes` TEXT DEFAULT NULL COMMENT 'Notas del administrador',
  `CreatedDateTime` DATETIME NOT NULL COMMENT 'Fecha de creación',
  `ProcessedDateTime` DATETIME DEFAULT NULL COMMENT 'Fecha de procesamiento',
  PRIMARY KEY (`ID`),
  KEY `idx_member` (`MemberID`),
  KEY `idx_status` (`Status`),
  KEY `idx_created` (`CreatedDateTime`),
  KEY `idx_server_email` (`ServerEmail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
COMMENT='Solicitudes de pago pendientes de verificación';

-- ====================================================================
-- Vista para el panel del miembro (ver sus propias solicitudes)
-- ====================================================================
CREATE OR REPLACE VIEW v_member_payment_requests AS
SELECT 
    pr.ID,
    pr.MemberID,
    pr.Amount,
    pr.PaymentMethod,
    pr.TransactionRef,
    pr.Status,
    CASE pr.Status
        WHEN 'pending' THEN '⏳ Pendiente de Verificación'
        WHEN 'approved' THEN '✅ Aprobado - Procesando'
        WHEN 'rejected' THEN '❌ Rechazado'
    END as StatusText,
    pr.CreatedDateTime as RequestDate,
    pr.ProcessedDateTime,
    pr.AdminNotes,
    TIMESTAMPDIFF(HOUR, pr.CreatedDateTime, NOW()) as HoursPending
FROM gsm_payment_requests pr
WHERE pr.Status = 'pending'
ORDER BY pr.CreatedDateTime DESC;

-- ====================================================================
-- Procedimiento para APROBAR solicitud y AGREGAR CRÉDITOS
-- ====================================================================
DELIMITER $$

DROP PROCEDURE IF EXISTS sp_aprobar_solicitud_pago$$

CREATE PROCEDURE sp_aprobar_solicitud_pago(
    IN p_request_id INT,
    IN p_admin_notes TEXT
)
BEGIN
    DECLARE v_member_id INT;
    DECLARE v_amount DECIMAL(10,2);
    DECLARE v_user_name VARCHAR(255);
    DECLARE v_payment_method VARCHAR(100);
    DECLARE v_transaction_ref VARCHAR(255);
    DECLARE v_next_transaction_id INT;
    
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SELECT 'Error' as Status, 'Error al procesar la solicitud' as Message;
    END;
    
    START TRANSACTION;
    
    -- Obtener datos de la solicitud
    SELECT 
        MemberID, 
        Amount, 
        UserName,
        PaymentMethod,
        TransactionRef
    INTO 
        v_member_id, 
        v_amount, 
        v_user_name,
        v_payment_method,
        v_transaction_ref
    FROM gsm_payment_requests
    WHERE ID = p_request_id AND Status = 'pending'
    FOR UPDATE;
    
    -- Verificar que la solicitud existe y está pendiente
    IF v_member_id IS NULL THEN
        ROLLBACK;
        SELECT 'Error' as Status, 'Solicitud no encontrada o ya procesada' as Message;
    ELSE
        -- Obtener el próximo ID de transacción para este miembro
        SELECT COALESCE(MAX(TransactionID), 0) + 1 
        INTO v_next_transaction_id
        FROM gsm_credits
        WHERE MemberID = v_member_id AND TransactionCode = 'P';
        
        -- Insertar crédito en gsm_credits (usando la estructura existente)
        INSERT INTO gsm_credits (
            TransactionCode,
            TransactionID,
            MemberID,
            Amount,
            Description,
            CreatedDateTime
        ) VALUES (
            'P',  -- P = Payment
            v_next_transaction_id,
            v_member_id,
            v_amount,
            CONCAT('Pago recibido: ', v_payment_method, 
                   IF(v_transaction_ref IS NOT NULL, CONCAT(' - Ref: ', v_transaction_ref), '')),
            NOW()
        );
        
        -- Marcar solicitud como aprobada
        UPDATE gsm_payment_requests
        SET Status = 'approved',
            ProcessedDateTime = NOW(),
            AdminNotes = p_admin_notes
        WHERE ID = p_request_id;
        
        COMMIT;
        
        SELECT 'Success' as Status, 
               CONCAT('Solicitud aprobada. Se agregaron $', v_amount, ' USD a la cuenta de ', v_user_name) as Message,
               v_amount as AmountAdded,
               v_member_id as MemberID;
    END IF;
END$$

DELIMITER ;

-- ====================================================================
-- Procedimiento para RECHAZAR solicitud
-- ====================================================================
DELIMITER $$

DROP PROCEDURE IF EXISTS sp_rechazar_solicitud_pago$$

CREATE PROCEDURE sp_rechazar_solicitud_pago(
    IN p_request_id INT,
    IN p_admin_notes TEXT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SELECT 'Error' as Status, 'Error al procesar la solicitud' as Message;
    END;
    
    START TRANSACTION;
    
    -- Marcar solicitud como rechazada
    UPDATE gsm_payment_requests
    SET Status = 'rejected',
        ProcessedDateTime = NOW(),
        AdminNotes = p_admin_notes
    WHERE ID = p_request_id AND Status = 'pending';
    
    IF ROW_COUNT() > 0 THEN
        COMMIT;
        SELECT 'Success' as Status, 'Solicitud rechazada correctamente' as Message;
    ELSE
        ROLLBACK;
        SELECT 'Error' as Status, 'Solicitud no encontrada o ya procesada' as Message;
    END IF;
END$$

DELIMITER ;

-- ====================================================================
-- INSTRUCCIONES DE USO
-- ====================================================================

/*
PARA APROBAR UNA SOLICITUD Y AGREGAR CRÉDITOS:
------------------------------------------------
CALL sp_aprobar_solicitud_pago(
    1,  -- ID de la solicitud
    'Pago verificado correctamente'  -- Notas del admin
);

PARA RECHAZAR UNA SOLICITUD:
-----------------------------
CALL sp_rechazar_solicitud_pago(
    1,  -- ID de la solicitud
    'Pago no verificado - datos incorrectos'  -- Motivo del rechazo
);

VER SOLICITUDES PENDIENTES:
---------------------------
SELECT * FROM gsm_payment_requests WHERE Status = 'pending' ORDER BY CreatedDateTime DESC;

VER TODAS LAS SOLICITUDES:
--------------------------
SELECT * FROM gsm_payment_requests ORDER BY CreatedDateTime DESC;

VER CRÉDITOS DE UN MIEMBRO:
---------------------------
SELECT * FROM gsm_credits WHERE MemberID = 1 ORDER BY CreatedDateTime DESC;

VER SALDO ACTUAL DE UN MIEMBRO:
--------------------------------
SELECT SUM(Amount) as Balance FROM gsm_credits WHERE MemberID = 1;
*/

-- ====================================================================
-- DATOS DE PRUEBA (Comentar en producción)
-- ====================================================================

/*
INSERT INTO gsm_payment_requests (
    MemberID, 
    UserName, 
    UserEmail, 
    ServerEmail, 
    Amount, 
    PaymentMethod, 
    TransactionRef, 
    Status, 
    CreatedDateTime
) VALUES (
    1,  -- Reemplazar con un MemberID real
    'Usuario de Prueba',
    'usuario@ejemplo.com',
    'djnachord@icloud.com',
    50.00,
    'usdt',
    'TRX123456789ABC',
    'pending',
    NOW()
);
*/

-- ====================================================================
SELECT '✅ Instalación completada correctamente!' as Mensaje;
-- ====================================================================

