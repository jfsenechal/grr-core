<?php
/**
 * This file is part of GrrSf application.
 *
 * @author jfsenechal <jfsenechal@gmail.com>
 * @date 10/09/19
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Grr\Core\Security\Ldap;

use Symfony\Component\Ldap\Adapter\AdapterInterface;
use Symfony\Component\Ldap\Adapter\EntryManagerInterface;
use Symfony\Component\Ldap\Adapter\QueryInterface;
use Symfony\Component\Ldap\Exception\ConnectionException;
use Symfony\Component\Ldap\Exception\DriverNotFoundException;
use Symfony\Component\Ldap\LdapInterface;

class LdapAuth implements LdapInterface
{
    private AdapterInterface $adapter;

    /**
     * @var string[]
     */
    private static array $adapterMap = [
        'ext_ldap' => 'Symfony\Component\Ldap\Adapter\ExtLdap\Adapter',
    ];

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Return a connection bound to the ldap.
     *
     * @param string $dn       A LDAP dn
     * @param string $password A password
     *
     * @throws ConnectionException if dn / password could not be bound
     */
    public function bind(string $dn = null, string $password = null): void
    {
        $this->adapter->getConnection()->bind($dn, $password);
    }

    /**
     * Queries a ldap server for entries matching the given criteria.
     *
     * @param string $dn
     * @param string $query
     */
    public function query($dn, $query, array $options = []): QueryInterface
    {
        return $this->adapter->createQuery($dn, $query, $options);
    }

    public function getEntryManager(): EntryManagerInterface
    {
        return $this->adapter->getEntryManager();
    }

    /**
     * Escape a string for use in an LDAP filter or DN.
     *
     * @param string $subject
     * @param string $ignore
     * @param int    $flags
     */
    public function escape($subject, $ignore = '', $flags = 0): string
    {
        return $this->adapter->escape($subject, $ignore, $flags);
    }

    /**
     * Creates a new Ldap instance.
     *
     * @param string $adapter The adapter name
     * @param array  $config  The adapter's configuration
     *
     * @return static
     */
    public static function create(string $adapter, array $config = []): self
    {
        if (!isset(self::$adapterMap[$adapter])) {
            throw new DriverNotFoundException(sprintf('Adapter "%s" not found. You should use one of: %s', $adapter, implode(', ', self::$adapterMap)));
        }

        $class = self::$adapterMap[$adapter];

        return new self(new $class($config));
    }
}
