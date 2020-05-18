<?php namespace AuthLdap\Config;
use CodeIgniter\Config\BaseConfig;

/**
 * Class AuthLdap
 * @package AuthLdap\Config
 * @author Karthikeyan C <karthikn.mca@gmail.com>
 */
class AuthLdap extends BaseConfig
{
    /**
     * LDAP configured Domain
     * @var string $ldapDomain
     */
    private $ldapDomain = 'ldap.forumsys.com';

    /**
     * Do you wanna TLS encrypted Connection?
     * @var bool $useTls
     */
    private $useTls = false;

    /**
     * TCP port 389 [unencrypted communication]
     * TCP port 636 [TLS encrypted Channel]
     * @var int[] $tcpPort
     */
    private $tcpPort = [
        'default'   =>  389,
        'tls'       =>  636
    ];

    /**
     * Distinguished Name
     * @var string $baseDn
     */
    private $baseDn = 'dc=example,dc=com';

    /**
     * uid - Individual User
     * @var string $ldapAttribute
     */
    private $ldapUserAttribute = 'uid';

    /**
     * ou - group
     * @var string $ldapGroupAttribute
     */
    private $ldapGroupAttribute = 'ou';

	/**
	 * LDAP search Attribute
	 * @var string[] $ldapSearchAttribute
	 */
	private $ldapSearchAttribute = ['dn', 'cn'];

	/**
	 * An identifier to retrieve member of groups
	 * from LDAP defined structure
	 * @var string $ldapMemberOfGroupsIdentifier (uniquemember/memberof)
	 */
	private $ldapMemberOfGroupsIdentifier = 'uniquemember';

    /**
     * Groups will be fetched at runtime
     * @var array $groups
     */
    private $groups = [];

    /**
     * user id group`ed by group/role(s)
     *
     * @var array $groupByUsers
     */
    private $groupByUsers = [];

    /**
     * ['curie' => 'chemists']
     * @var array $userNameAndGroup
     */
    private $userNameAndGroup = [];

    /**
     * get TLS
     * @author Karthikeyan C <karthikn.mca@gmail.com>
     */
    public function isTlsEnabled()
    {
        $this->useTls;
    }

    /**
     * Get Base DN
     * @return string
     * @author Karthikeyan C <karthikn.mca@gmail.com>
     */
    public function getLdapBaseDN(): string
    {
        return $this->baseDn;
    }

	/**
	 * Get Group Attribute
	 * @return string
	 * @author Karthikeyan C <karthikn.mca@gmail.com>
	 */
	public function getLdapGroupAttribute(): string
	{
		return $this->ldapGroupAttribute;
	}

	/**
	 * Get User Attribute
	 * @return string
	 * @author Karthikeyan C <karthikn.mca@gmail.com>
	 */
	public function getLdapUserAttribute(): string
	{
		return $this->ldapUserAttribute;
	}

    /**
     * Construct ldap url and return
     * @return string
     * @author Karthikeyan C <karthikn.mca@gmail.com>
     */
    public function getLdapUrl(): string
    {
        return sprintf("ldap://%s:%d",
            $this->ldapDomain,
            $this->useTls ? $this->tcpPort['tls'] : $this->tcpPort['default']
        );
    }

	/**
	 * get Search Attribute
	 * @return array
	 * @author Karthikeyan C <karthikn.mca@gmail.com>
	 */
    public function getLdapSearchAttribute(): array
	{
		return $this->ldapSearchAttribute;
	}

	/**
	 * get Member of Groups Identifier
	 * @return string
	 * @author Karthikeyan C <karthikn.mca@gmail.com>
	 */
	public function getLdapMemberOfGroupsIdentifier(): string
	{
		return $this->ldapMemberOfGroupsIdentifier;
	}

    /**
     * Set Group
     * @param string $groupName
     * @param array $users
     * @author Karthikeyan C <karthikn.mca@gmail.com>
     */
    public function setGroup(string $groupName, array $users): void
    {
        if (!in_array($groupName, $this->groups, true))
        {
            array_push($this->groups, $groupName);
            $this->groupByUsers[$groupName] = $users;
        }
    }

    /**
     * @param string $userName
     * @param string $groupName
     * @author Karthikeyan C <karthikn.mca@gmail.com>
     */
    public function setUserAndGroup(string $userName, string $groupName): void
    {
			$this->userNameAndGroup[$userName][] = $groupName;
    }

    /**
     * get Groups
     * @return array
     * @author Karthikeyan C <karthikn.mca@gmail.com>
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

    /**
     * get All Users by their roles/group-names
     * @return array
     * @author Karthikeyan C <karthikn.mca@gmail.com>
     */
    public function getGroupByUsers(): array
    {
        return $this->groupByUsers;
    }

    /**
     * get Role by Username
     * @param $userName
     * @return array
     * @author Karthikeyan C <karthikn.mca@gmail.com>
     */
    public function getRoleByUserName($userName): array
    {
        return $this->userNameAndGroup[$userName] ?? [];
    }
}
