<?php
/**
 * Password Helper - Modern Security
 * Reemplaza MD5 con password_hash/password_verify
 * 
 * @package     NachoTechRD
 * @category    Helpers
 * @author      NachoTechRD Dev Team
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Hash a password using bcrypt (secure)
 * 
 * @param string $password Plain text password
 * @return string Hashed password
 */
if (!function_exists('hash_password')) {
    function hash_password($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
}

/**
 * Verify a password against a hash
 * 
 * @param string $password Plain text password
 * @param string $hash Hashed password from database
 * @return bool True if password matches
 */
if (!function_exists('verify_password')) {
    function verify_password($password, $hash) {
        // Si el hash es MD5 (legacy), verificar y actualizar
        if (strlen($hash) === 32 && ctype_xdigit($hash)) {
            // Es MD5, verificar y migrar
            if (md5($password) === $hash) {
                // Password correcto, pero necesitaría actualizarse después
                return true;
            }
            return false;
        }
        // Hash moderno (bcrypt)
        return password_verify($password, $hash);
    }
}

/**
 * Migrate MD5 password to bcrypt
 * Use this after verifying with MD5 to upgrade
 * 
 * @param string $password Plain text password
 * @return string New bcrypt hash
 */
if (!function_exists('migrate_password')) {
    function migrate_password($password) {
        return hash_password($password);
    }
}

