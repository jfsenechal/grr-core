<?php

namespace Grr\Core\Security\Ldap;

use Exception;
use Symfony\Component\Ldap\Adapter\EntryManagerInterface;
use Symfony\Component\Ldap\Exception\LdapException;
use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class GrrLdap
{
    private Ldap $ldap;
    private string $dn;
    private string $user;
    private string $password;

    public function __construct(string $host, $dn, string $user, string $password)
    {
        $this->ldap = Ldap::create(
            'ext_ldap',
            [
                'host' => $host,
                'encryption' => 'ssl',
            ]
        );

        $this->user = $user;
        $this->password = $password;

        $this->dn = $dn;
    }

    /**
     * @param $uid
     *
     * @return mixed|null
     */
    public function getEntry($uid)
    {
        $this->ldap->bind($this->user, $this->password);
        $filter = "(&(|(sAMAccountName=*$uid*))(objectClass=person))";
        $query = $this->ldap->query($this->dn, $filter, ['maxItems' => 1]);
        $results = $query->execute();

        if ($results->count() > 0) {
            return $results[0];
        }

        return null;
    }

    /**
     * @param $user
     * @param $password
     *
     * @throws LdapException
     */
    public function bind($user, $password): void
    {
        try {
            $this->ldap->bind($user, $password);
        } catch (Exception $exception) {
            throw new BadCredentialsException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function getEntryManager(): EntryManagerInterface
    {
        return $this->ldap->getEntryManager();
    }
}
