<?php
use MediaWiki\Rest\Handler;
use MediaWiki\MediaWikiServices;

class ApiThumbFeedback extends ApiBase {
    public function execute() {
        $params = $this->extractRequestParams();
        $title = $params['title'] ?? '';
        $vote = (int)($params['vote'] ?? 0);
        $comment = $params['comment'] ?? '';
        $user = $this->getUser()->getName();

        $dbw = wfGetDB( DB_MASTER );
        $dbw->insert(
            'thumbfeedback',
            [
                'tf_page' => $title,
                'tf_user' => $user,
                'tf_vote' => $vote,
                'tf_comment' => $comment,
                'tf_timestamp' => $dbw->timestamp()
            ],
            __METHOD__
        );

        $this->getResult()->addValue( null, 'thumbfeedback', [ 'result' => 'success' ] );
    }

    public function getAllowedParams() {
        return [
            'title' => null,
            'vote' => null,
            'comment' => null,
        ];
    }
}
?>