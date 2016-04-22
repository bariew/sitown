<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 21.04.16
 * Time: 18:49
 */

namespace app\modules\code\components;


use Github\Client;
use yii\base\Component;

class Github extends Component
{
    /**
     * @var string alternative url to git storage.
     * Leave it empty for github.com
     */
    public $enterpriseUrl;

    /**
     * @var string Git auth key.
     * @see https://help.github.com/articles/creating-an-access-token-for-command-line-use/
     */
    public $authKey;

    /**
     * @var string git user name.
     */
    public $owner;

    /**
     * @var string git repository name.
     */
    public $repository;

    /**
     * @var Client
     */
    private $api;

    private $repoInfo;

    public function init()
    {
        parent::init();
        $this->api = new Client();
        if ($this->enterpriseUrl) {
            $this->api->setEnterpriseUrl($this->enterpriseUrl);
        }
        $this->api->authenticate($this->authKey, null, Client::AUTH_URL_TOKEN);
        //$this->repoInfo = $this->api->repository()->show($this->owner, $this->repository);

    }

    //$this->pullRequestMerge($result[0]['number'], $result[0]['head']['sha']);
    /**
     * @param $id
     * @param $sha
     * @param string $message
     * @return array like
        {
            "sha": "6dcb09b5b57875f334f61aebed695e2e4193db5e",
            "merged": true,
            "message": "Pull Request successfully merged"
        }
     */
    public function pullRequestMerge($id, $sha, $message = 'Auto merge')
    {
        try {
            $result = $this->api->pullRequest()->merge($this->owner, $this->repository, $id, $message, $sha);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return $result;
    }
    /**
     * @param $id
     * @param array $params like ["state" => "closed"]
     * @return array
     */
    public function pullRequestUpdate($id, $params = [])
    {
        try {
            $result = $this->api->pullRequest()->update($this->owner, $this->repository, $id, $params);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return $result;
    }

    public function pullRequestList($params = [])
    {
        $result = $this->api->pullRequest()->all($this->owner, $this->repository, $params);
        return $result;
    }

    public function pullRequestUrl($number)
    {
        return "https://github.com/{$this->owner}/{$this->repository}/pull/{$number}";
    }
}
/**
Array
(
[id] => 56622214
[name] => sitown
[full_name] => bariew/sitown
[owner] => Array
(
[login] => bariew
[id] => 827508
[avatar_url] => https://avatars.githubusercontent.com/u/827508?v=3
[gravatar_id] =>
[url] => https://api.github.com/users/bariew
[html_url] => https://github.com/bariew
[followers_url] => https://api.github.com/users/bariew/followers
[following_url] => https://api.github.com/users/bariew/following{/other_user}
[gists_url] => https://api.github.com/users/bariew/gists{/gist_id}
[starred_url] => https://api.github.com/users/bariew/starred{/owner}{/repo}
[subscriptions_url] => https://api.github.com/users/bariew/subscriptions
[organizations_url] => https://api.github.com/users/bariew/orgs
[repos_url] => https://api.github.com/users/bariew/repos
[events_url] => https://api.github.com/users/bariew/events{/privacy}
[received_events_url] => https://api.github.com/users/bariew/received_events
[type] => User
[site_admin] =>
)

[private] =>
[html_url] => https://github.com/bariew/sitown
[description] =>
[fork] =>
[url] => https://api.github.com/repos/bariew/sitown
[forks_url] => https://api.github.com/repos/bariew/sitown/forks
[keys_url] => https://api.github.com/repos/bariew/sitown/keys{/key_id}
[collaborators_url] => https://api.github.com/repos/bariew/sitown/collaborators{/collaborator}
[teams_url] => https://api.github.com/repos/bariew/sitown/teams
[hooks_url] => https://api.github.com/repos/bariew/sitown/hooks
[issue_events_url] => https://api.github.com/repos/bariew/sitown/issues/events{/number}
[events_url] => https://api.github.com/repos/bariew/sitown/events
[assignees_url] => https://api.github.com/repos/bariew/sitown/assignees{/user}
[branches_url] => https://api.github.com/repos/bariew/sitown/branches{/branch}
[tags_url] => https://api.github.com/repos/bariew/sitown/tags
[blobs_url] => https://api.github.com/repos/bariew/sitown/git/blobs{/sha}
[git_tags_url] => https://api.github.com/repos/bariew/sitown/git/tags{/sha}
[git_refs_url] => https://api.github.com/repos/bariew/sitown/git/refs{/sha}
[trees_url] => https://api.github.com/repos/bariew/sitown/git/trees{/sha}
[statuses_url] => https://api.github.com/repos/bariew/sitown/statuses/{sha}
[languages_url] => https://api.github.com/repos/bariew/sitown/languages
[stargazers_url] => https://api.github.com/repos/bariew/sitown/stargazers
[contributors_url] => https://api.github.com/repos/bariew/sitown/contributors
[subscribers_url] => https://api.github.com/repos/bariew/sitown/subscribers
[subscription_url] => https://api.github.com/repos/bariew/sitown/subscription
[commits_url] => https://api.github.com/repos/bariew/sitown/commits{/sha}
[git_commits_url] => https://api.github.com/repos/bariew/sitown/git/commits{/sha}
[comments_url] => https://api.github.com/repos/bariew/sitown/comments{/number}
[issue_comment_url] => https://api.github.com/repos/bariew/sitown/issues/comments{/number}
[contents_url] => https://api.github.com/repos/bariew/sitown/contents/{+path}
[compare_url] => https://api.github.com/repos/bariew/sitown/compare/{base}...{head}
[merges_url] => https://api.github.com/repos/bariew/sitown/merges
[archive_url] => https://api.github.com/repos/bariew/sitown/{archive_format}{/ref}
[downloads_url] => https://api.github.com/repos/bariew/sitown/downloads
[issues_url] => https://api.github.com/repos/bariew/sitown/issues{/number}
[pulls_url] => https://api.github.com/repos/bariew/sitown/pulls{/number}
[milestones_url] => https://api.github.com/repos/bariew/sitown/milestones{/number}
[notifications_url] => https://api.github.com/repos/bariew/sitown/notifications{?since,all,participating}
[labels_url] => https://api.github.com/repos/bariew/sitown/labels{/name}
[releases_url] => https://api.github.com/repos/bariew/sitown/releases{/id}
[deployments_url] => https://api.github.com/repos/bariew/sitown/deployments
[created_at] => 2016-04-19T18:40:00Z
[updated_at] => 2016-04-20T18:17:22Z
[pushed_at] => 2016-04-21T15:26:26Z
[git_url] => git://github.com/bariew/sitown.git
[ssh_url] => git@github.com:bariew/sitown.git
[clone_url] => https://github.com/bariew/sitown.git
[svn_url] => https://github.com/bariew/sitown
[homepage] =>
[size] => 1494
[stargazers_count] => 0
[watchers_count] => 0
[language] => PHP
[has_issues] => 1
[has_downloads] => 1
[has_wiki] => 1
[has_pages] =>
[forks_count] => 1
[mirror_url] =>
[open_issues_count] => 1
[forks] => 1
[open_issues] => 1
[watchers] => 0
[default_branch] => master
[permissions] => Array
(
[admin] => 1
[push] => 1
[pull] => 1
)

[network_count] => 1
[subscribers_count] => 1
)

 */