<?php

require dirname(__DIR__).'/vendor/autoload.php';

/*
 * Polyfills for LDAP functions when ext-ldap is not installed.
 * These allow tests to run in environments without the LDAP extension.
 */

if (!function_exists('ldap_explode_dn')) {
    /**
     * Polyfill for ldap_explode_dn().
     *
     * Splits a DN string into its component parts.
     *
     * @param string $dn
     * @param int    $withAttrib 0 = with attribute prefixes, 1 = without
     *
     * @return array|false
     */
    function ldap_explode_dn($dn, $withAttrib)
    {
        $dn = trim($dn);

        if (empty($dn)) {
            return false;
        }

        // A valid DN must contain at least one '=' in its first component.
        // The native ldap_explode_dn returns false for invalid DNs.
        if (strpos($dn, '=') === false) {
            return false;
        }

        // Split the DN by commas, but not commas inside escaped values.
        $components = preg_split('/(?<!\\\\),/', $dn);

        if ($components === false) {
            return false;
        }

        $result = ['count' => count($components)];

        foreach ($components as $i => $component) {
            if ($withAttrib) {
                // Remove attribute prefix (e.g., "cn=" from "cn=John Doe")
                $pos = strpos($component, '=');
                $result[$i] = $pos !== false ? substr($component, $pos + 1) : $component;
            } else {
                $result[$i] = $component;
            }
        }

        return $result;
    }
}

if (!function_exists('ldap_connect')) {
    /**
     * Polyfill for ldap_connect().
     *
     * Returns a dummy resource simulating an LDAP connection.
     *
     * @param string|null $uri
     *
     * @return resource
     */
    function ldap_connect($uri = null)
    {
        return stream_context_create();
    }
}

if (!function_exists('ldap_set_option')) {
    function ldap_set_option($connection, $option, $value)
    {
        return true;
    }
}

if (!function_exists('ldap_bind')) {
    function ldap_bind($connection, $dn = null, $password = null)
    {
        return true;
    }
}

if (!function_exists('ldap_error')) {
    function ldap_error($connection)
    {
        return '';
    }
}

if (!function_exists('ldap_errno')) {
    function ldap_errno($connection)
    {
        return 0;
    }
}

if (!function_exists('ldap_close')) {
    function ldap_close($connection)
    {
        return true;
    }
}

if (!function_exists('ldap_get_option')) {
    function ldap_get_option($connection, $option, &$value = null)
    {
        $value = '';
        return true;
    }
}

if (!function_exists('ldap_start_tls')) {
    function ldap_start_tls($connection)
    {
        return true;
    }
}

if (!function_exists('ldap_free_result')) {
    function ldap_free_result($result)
    {
        return true;
    }
}

if (!function_exists('ldap_err2str')) {
    function ldap_err2str($number)
    {
        return 'LDAP error '.$number;
    }
}

if (!function_exists('ldap_search')) {
    function ldap_search($connection, $base_dn, $filter, $attributes = [], $attrsonly = 0, $sizelimit = 0, $timelimit = 0)
    {
        return false;
    }
}

if (!function_exists('ldap_list')) {
    function ldap_list($connection, $base_dn, $filter, $attributes = [], $attrsonly = 0, $sizelimit = 0, $timelimit = 0)
    {
        return false;
    }
}

if (!function_exists('ldap_read')) {
    function ldap_read($connection, $base_dn, $filter, $attributes = [], $attrsonly = 0, $sizelimit = 0, $timelimit = 0)
    {
        return false;
    }
}

if (!function_exists('ldap_get_entries')) {
    function ldap_get_entries($connection, $result)
    {
        return ['count' => 0];
    }
}

if (!function_exists('ldap_parse_result')) {
    function ldap_parse_result($connection, $result, &$errcode, &$matcheddn = '', &$errmsg = '', &$referrals = [], &$serverctrls = [])
    {
        $errcode = 0;
        $matcheddn = '';
        $errmsg = '';
        $referrals = [];
        $serverctrls = [];
        return true;
    }
}

if (!function_exists('ldap_first_entry')) {
    function ldap_first_entry($connection, $result)
    {
        return false;
    }
}

if (!function_exists('ldap_next_entry')) {
    function ldap_next_entry($connection, $entry)
    {
        return false;
    }
}

if (!function_exists('ldap_get_attributes')) {
    function ldap_get_attributes($connection, $entry)
    {
        return ['count' => 0];
    }
}

if (!function_exists('ldap_count_entries')) {
    function ldap_count_entries($connection, $result)
    {
        return 0;
    }
}

if (!function_exists('ldap_compare')) {
    function ldap_compare($connection, $dn, $attribute, $value)
    {
        return false;
    }
}

if (!function_exists('ldap_get_values_len')) {
    function ldap_get_values_len($connection, $entry, $attribute)
    {
        return false;
    }
}

if (!function_exists('ldap_set_rebind_proc')) {
    function ldap_set_rebind_proc($connection, $callback)
    {
        return true;
    }
}

if (!function_exists('ldap_add')) {
    function ldap_add($connection, $dn, $entry)
    {
        return true;
    }
}

if (!function_exists('ldap_delete')) {
    function ldap_delete($connection, $dn)
    {
        return true;
    }
}

if (!function_exists('ldap_rename')) {
    function ldap_rename($connection, $dn, $new_rdn, $new_parent, $delete_old_rdn)
    {
        return true;
    }
}

if (!function_exists('ldap_modify')) {
    function ldap_modify($connection, $dn, $entry)
    {
        return true;
    }
}

if (!function_exists('ldap_modify_batch')) {
    function ldap_modify_batch($connection, $dn, $modifications)
    {
        return true;
    }
}

if (!function_exists('ldap_mod_add')) {
    function ldap_mod_add($connection, $dn, $entry)
    {
        return true;
    }
}

if (!function_exists('ldap_mod_replace')) {
    function ldap_mod_replace($connection, $dn, $entry)
    {
        return true;
    }
}

if (!function_exists('ldap_mod_del')) {
    function ldap_mod_del($connection, $dn, $entry)
    {
        return true;
    }
}

if (!function_exists('ldap_sasl_bind')) {
    function ldap_sasl_bind($connection, $dn = null, $password = null, $mech = null, $realm = null, $authc_id = null, $authz_id = null, $props = null)
    {
        return true;
    }
}

if (!function_exists('ldap_escape')) {
    /**
     * Polyfill for ldap_escape().
     *
     * Escape a string for use in an LDAP filter or DN.
     *
     * @param string $value
     * @param string $ignore Characters to ignore when escaping
     * @param int    $flags  LDAP_ESCAPE_FILTER=1, LDAP_ESCAPE_DN=2
     *
     * @return string
     */
    function ldap_escape($value, $ignore = '', $flags = 0)
    {
        if (!defined('LDAP_ESCAPE_FILTER')) {
            define('LDAP_ESCAPE_FILTER', 1);
        }

        if (!defined('LDAP_ESCAPE_DN')) {
            define('LDAP_ESCAPE_DN', 2);
        }

        $value = (string) $value;

        // Build a map of characters to ignore.
        $ignoreMap = [];
        for ($i = 0, $len = strlen($ignore); $i < $len; $i++) {
            $ignoreMap[$ignore[$i]] = true;
        }

        $escaped = '';

        for ($i = 0, $len = strlen($value); $i < $len; $i++) {
            $char = $value[$i];

            // Skip characters in the ignore list.
            if (isset($ignoreMap[$char])) {
                $escaped .= $char;
                continue;
            }

            $shouldEscape = false;

            if ($flags === 0) {
                // When no flags are set, escape ALL characters.
                $shouldEscape = true;
            } else {
                if ($flags & LDAP_ESCAPE_FILTER) {
                    // Characters that must be escaped for LDAP filter strings.
                    if ($char === '\\' || $char === '*' || $char === '(' || $char === ')' || $char === "\x00") {
                        $shouldEscape = true;
                    }
                }

                if ($flags & LDAP_ESCAPE_DN) {
                    // Characters that must be escaped for LDAP DN strings.
                    if ($char === '\\' || $char === ',' || $char === '=' || $char === '+' ||
                        $char === '<' || $char === '>' || $char === ';' || $char === '"' || $char === '#') {
                        $shouldEscape = true;
                    }
                }
            }

            if ($shouldEscape) {
                $escaped .= sprintf('\\%02x', ord($char));
            } else {
                $escaped .= $char;
            }
        }

        return $escaped;
    }
}
