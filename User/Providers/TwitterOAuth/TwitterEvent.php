<?php
/**
 * Webiny Framework (http://www.webiny.com/framework)
 *
 * @copyright Copyright Webiny LTD
 */

namespace Webiny\Component\Security\User\Providers\TwitterOAuth;

use Webiny\Component\EventManager\Event;
use Webiny\Component\TwitterOAuth\TwitterOAuth;
use Webiny\Component\TwitterOAuth\TwitterOAuthUser;

/**
 * This class is passed along with events fired by Twitter user provider.
 *
 * @package         Webiny\Component\Security\User\Providers\OAuth2
 */
class TwitterEvent extends Event
{

    const TWITTER_AUTH_SUCCESS = 'wf.security.user.twitter';

    /**
     * @var \Webiny\Component\TwitterOAuth\TwitterOAuthUser
     */
    private $_twitterUser;

    /**
     * @var \Webiny\Component\TwitterOAuth\TwitterOAuth
     */
    private $_oauth;

    public function __construct(TwitterOAuthUser $twitterUser, TwitterOAuth $twitterOAuth)
    {
        $this->_twitterUser = $twitterUser;
        $this->_oauth = $twitterOAuth;
    }

    /**
     * Returns current user authenticated by Twitter OAuth.
     *
     * @return TwitterOAuthUser
     */
    public function getUser()
    {
        return $this->_twitterUser;
    }

    /**
     * Get the current TwitterOAuth instance.
     * This instance holds the access key.
     *
     * @return TwitterOAuth
     */
    public function getTwitterOAuthInstance()
    {
        return $this->_oauth;
    }
}