<?php

namespace App\Livewire\Social\Post;

use App\Models\Social\Post\PostComment;
use Exception;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class PostCommentBlock extends Component
{
    use LivewireAlert;

    public PostComment $comment;

    public function reject(int $id)
    {
        $comment = PostComment::find($id);
        try {
            $comment->reject()->create([
                'reason' => 'Non respect des règles communautaires',
                'post_comment_id' => $comment->id,
            ]);

            $this->alert('success', 'Commentaire rejeté');
        } catch (Exception $e) {
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function render()
    {
        return view('livewire.social.post.post-comment-block');
    }
}
