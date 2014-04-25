<?php

namespace Phpmvc\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentsInSession implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;



    /**
     * Add a new comment
     *
     * @param array $comment with all details.
     * 
     * @return void
     */
    public function add($comment)
    {
        $comments = $this->session->get('comments', []);
        $comments[] = $comment;
        $this->session->set('comments', $comments);
    }



    /**
     * Find and return all comments.
     *
     * @return array with all comments.
     */
    public function findAll()
    {
        return $this->session->get('comments', []);
    }

     /**
     * Find and return comment with id
     *
     * @return a comment.
     */
    public function find($id) 
    {
        $comments = $this->session->get('comments', []);
        return $comments[$id];
    }



    /**
     * Delete all comments.
     *
     * @return void
     */
    public function deleteAll()
    {
        $this->session->set('comments', []);
    }
    
    /**
     * Delete a comment
     * @param int $id the id.
     * @return void
     */
    public function delete($id) 
    {
        // Get all comments.
        $comments = $this->session->get('comments', []);
        // Remove the comment.
        unset($comments[$id]);
        // Set the new array.
        $this->session->set('comments', $comments);
    }

    public function save($comment, $id = null) {
        $comments = $this->session->get('comments', []);
        $comments[$id] = $comment;
        $this->session->set('comments', $comments);
    }
}
