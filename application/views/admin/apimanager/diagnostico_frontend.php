<style>
.diagnostico-section {
    background: white;
    padding: 20px;
    margin: 20px 0;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-left: 4px solid #8b5cf6;
}

.diagnostico-section h2 {
    color: #8b5cf6;
    border-bottom: 2px solid #8b5cf6;
    padding-bottom: 10px;
    margin-bottom: 15px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

th, td {
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
    font-size: 13px;
}

th {
    background: #8b5cf6;
    color: white;
}

tr:nth-child(even) {
    background: #f9f9f9;
}

.status-enabled {
    color: #10b981;
    font-weight: bold;
}

.status-disabled {
    color: #dc2626;
    font-weight: bold;
}

.status-warning {
    color: #f59e0b;
    font-weight: bold;
}

.info-badge {
    display: inline-block;
    padding: 5px 12px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 13px;
    margin: 5px;
}

.badge-success {
    background: #d1fae5;
    color: #065f46;
}

.badge-error {
    background: #fee2e2;
    color: #991b1b;
}

.badge-warning {
    background: #fef3c7;
    color: #92400e;
}

.badge-info {
    background: #dbeafe;
    color: #1e40af;
}
</style>

<div class="workplace">
    <div class="head clearfix">
        <div class="isw-grid"></div>
        <h1>🔍 Diagnóstico: Servicios IMEI en Frontend</h1>
    </div>
    
    <!-- Resumen General -->
    <div class="diagnostico-section">
        <h2>📊 Resumen General</h2>
        <div>
            <span class="info-badge badge-info">
                Total Grupos: <strong><?php echo $total_grupos; ?></strong>
            </span>
            <span class="info-badge badge-success">
                Servicios en Frontend: <strong><?php echo $total_servicios_frontend; ?></strong>
            </span>
            <span class="info-badge badge-warning">
                Servicios Recientes (24h): <strong><?php echo count($servicios_recientes); ?></strong>
            </span>
            <span class="info-badge badge-error">
                Con Problemas: <strong><?php echo count($servicios_problemas); ?></strong>
            </span>
        </div>
        <p style="margin-top: 15px; color: #64748b;">
            <strong>✅ Servicios que aparecen:</strong> Solo los que tienen Status='Enabled', API Status='Enabled' y ApiType='Imei'
        </p>
    </div>
    
    <!-- Servicios Recientes -->
    <div class="diagnostico-section">
        <h2>1️⃣ Servicios Agregados Recientemente (Últimas 24 horas)</h2>
        <?php if(!empty($servicios_recientes)): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>ApiID</th>
                <th>API</th>
                <th>Título</th>
                <th>GROUPNAME</th>
                <th>Precio</th>
                <th>Status</th>
                <th>ApiStatus</th>
                <th>ApiType</th>
                <th>Fecha</th>
                <th>¿Aparece?</th>
            </tr>
            <?php foreach($servicios_recientes as $servicio): 
                $aparece = ($servicio['Status'] == 'Enabled' && 
                           isset($servicio['ApiStatus']) && $servicio['ApiStatus'] == 'Enabled' && 
                           isset($servicio['ApiType']) && $servicio['ApiType'] == 'Imei');
            ?>
            <tr>
                <td><?php echo $servicio['ID']; ?></td>
                <td><?php echo $servicio['ApiID']; ?></td>
                <td><?php echo htmlspecialchars($servicio['ApiTitle'] ?: 'API no encontrada'); ?></td>
                <td><?php echo htmlspecialchars($servicio['Title']); ?></td>
                <td><strong><?php echo htmlspecialchars($servicio['Description'] ?: 'Sin Grupo'); ?></strong></td>
                <td>$<?php echo number_format($servicio['Price'], 2); ?></td>
                <td class="<?php echo $servicio['Status'] == 'Enabled' ? 'status-enabled' : 'status-disabled'; ?>">
                    <?php echo $servicio['Status']; ?>
                </td>
                <td class="<?php echo (isset($servicio['ApiStatus']) && $servicio['ApiStatus'] == 'Enabled') ? 'status-enabled' : 'status-disabled'; ?>">
                    <?php echo $servicio['ApiStatus'] ?: 'N/A'; ?>
                </td>
                <td class="<?php echo (isset($servicio['ApiType']) && $servicio['ApiType'] == 'Imei') ? 'status-enabled' : 'status-warning'; ?>">
                    <?php echo $servicio['ApiType'] ?: 'N/A'; ?>
                </td>
                <td><?php echo $servicio['CreatedDateTime']; ?></td>
                <td class="<?php echo $aparece ? 'status-enabled' : 'status-disabled'; ?>">
                    <strong><?php echo $aparece ? '✅ SÍ' : '❌ NO'; ?></strong>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
        <p class="status-warning">⚠️ No se encontraron servicios agregados en las últimas 24 horas</p>
        <?php endif; ?>
    </div>
    
    <!-- Servicios que Aparecen en Frontend -->
    <div class="diagnostico-section">
        <h2>2️⃣ Servicios que DEBERÍAN Aparecer en Frontend</h2>
        <?php if(!empty($servicios_frontend)): ?>
        <p class="status-enabled">✅ <strong><?php echo count($servicios_frontend); ?></strong> servicios cumplen todos los criterios</p>
        <table>
            <tr>
                <th>ID</th>
                <th>ApiID</th>
                <th>API</th>
                <th>Título</th>
                <th>GROUPNAME</th>
                <th>Precio</th>
                <th>Fecha Creación</th>
            </tr>
            <?php foreach($servicios_frontend as $servicio): ?>
            <tr>
                <td><?php echo $servicio['ID']; ?></td>
                <td><?php echo $servicio['ApiID']; ?></td>
                <td><?php echo htmlspecialchars($servicio['ApiTitle']); ?></td>
                <td><?php echo htmlspecialchars($servicio['Title']); ?></td>
                <td><strong><?php echo htmlspecialchars($servicio['Description'] ?: 'Sin Grupo'); ?></strong></td>
                <td>$<?php echo number_format($servicio['Price'], 2); ?></td>
                <td><?php echo $servicio['CreatedDateTime']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
        <p class="status-disabled">❌ <strong>NO HAY servicios</strong> que cumplan los criterios para aparecer en el frontend</p>
        <?php endif; ?>
    </div>
    
    <!-- Servicios con Problemas -->
    <div class="diagnostico-section">
        <h2>3️⃣ Servicios que NO Aparecen (Diagnóstico)</h2>
        <?php if(!empty($servicios_problemas)): ?>
        <table>
            <tr>
                <th>ID Servicio</th>
                <th>ApiID</th>
                <th>Título</th>
                <th>Status Servicio</th>
                <th>Status API</th>
                <th>ApiType</th>
                <th>Razón</th>
            </tr>
            <?php foreach($servicios_problemas as $servicio): ?>
            <tr>
                <td><?php echo $servicio['ID']; ?></td>
                <td><?php echo $servicio['ApiID']; ?></td>
                <td><?php echo htmlspecialchars($servicio['Title']); ?></td>
                <td class="<?php echo $servicio['MethodStatus'] == 'Enabled' ? 'status-enabled' : 'status-disabled'; ?>">
                    <?php echo $servicio['MethodStatus']; ?>
                </td>
                <td class="<?php echo (isset($servicio['ApiStatus']) && $servicio['ApiStatus'] == 'Enabled') ? 'status-enabled' : 'status-disabled'; ?>">
                    <?php echo $servicio['ApiStatus'] ?: 'N/A'; ?>
                </td>
                <td><?php echo $servicio['ApiType'] ?: 'N/A'; ?></td>
                <td class="status-warning"><strong><?php echo htmlspecialchars($servicio['Razon']); ?></strong></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
        <p class="status-enabled">✅ Todos los servicios deberían aparecer correctamente</p>
        <?php endif; ?>
    </div>
    
    <!-- APIs Configuradas -->
    <div class="diagnostico-section">
        <h2>4️⃣ APIs Configuradas</h2>
        <?php if(!empty($apis)): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>ApiType</th>
                <th>Status</th>
                <th>Host</th>
                <th>Total Servicios</th>
                <th>Servicios Habilitados</th>
            </tr>
            <?php foreach($apis as $api): ?>
            <tr>
                <td><?php echo $api['ID']; ?></td>
                <td><?php echo htmlspecialchars($api['Title']); ?></td>
                <td class="<?php echo strtolower($api['ApiType']) == 'imei' ? 'status-enabled' : 'status-warning'; ?>">
                    <strong><?php echo $api['ApiType']; ?></strong>
                </td>
                <td class="<?php echo $api['Status'] == 'Enabled' ? 'status-enabled' : 'status-disabled'; ?>">
                    <?php echo $api['Status']; ?>
                </td>
                <td><?php echo htmlspecialchars($api['Host']); ?></td>
                <td><?php echo $api['total_servicios']; ?></td>
                <td><?php echo $api['servicios_habilitados']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    
    <!-- Grupos Agrupados (como aparecen en frontend) -->
    <div class="diagnostico-section">
        <h2>5️⃣ Servicios Agrupados (Como Aparecen en Frontend)</h2>
        <?php if(!empty($resumen)): ?>
            <?php foreach($resumen as $group_id => $grupo): ?>
            <div style="margin: 20px 0; padding: 15px; background: #f9fafb; border-radius: 8px; border-left: 4px solid #8b5cf6;">
                <h3 style="color: #8b5cf6; margin: 0 0 10px 0;">
                    📁 <?php echo htmlspecialchars($grupo['Title']); ?>
                    <span style="font-size: 14px; color: #64748b;">(<?php echo count($grupo['methods']); ?> servicios)</span>
                </h3>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Precio</th>
                        <th>GROUPNAME</th>
                    </tr>
                    <?php foreach($grupo['methods'] as $method): ?>
                    <tr>
                        <td><?php echo $method['ID']; ?></td>
                        <td><?php echo htmlspecialchars($method['Title']); ?></td>
                        <td>$<?php echo number_format($method['Price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($method['Description'] ?: 'Sin Grupo'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
        <p class="status-disabled">❌ No hay servicios agrupados (no hay servicios que cumplan los criterios)</p>
        <?php endif; ?>
    </div>
    
    <!-- Soluciones -->
    <div class="diagnostico-section">
        <h2>🔧 Soluciones Comunes</h2>
        <ul style="line-height: 2;">
            <li><strong>Si los servicios no aparecen:</strong>
                <ul>
                    <li>Verifica que la API esté <strong>habilitada</strong> en Admin Panel → API Manager</li>
                    <li>Verifica que el <strong>ApiType</strong> sea exactamente <strong>"Imei"</strong> (con I mayúscula)</li>
                    <li>Verifica que los servicios tengan <strong>Status = 'Enabled'</strong> en Admin Panel → Methods</li>
                </ul>
            </li>
            <li><strong>Si el ApiType está mal:</strong> Ve a Admin Panel → API Manager → Edita la API → Cambia el tipo a "Imei"</li>
            <li><strong>Si los servicios están deshabilitados:</strong> Ve a Admin Panel → Methods → Habilita los servicios</li>
        </ul>
    </div>
    
</div>

