<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $posts = json_decode(file_get_contents(base_path().'/database/posts.json'));
        $comments = json_decode(file_get_contents(base_path().'/database/comments.json'));

        foreach ($posts as $item) {
            Post::create([
                'title'=>$item->title,
                'body'=>$item->body
            ]);
        }

        foreach ($comments as $item) {
            $post = Post::find($item->postId);
            if ($post!==null) {
                Comment::create([
                    'post_id'=>$item->postId,
                    'name'=>$item->name,
                    'email'=>$item->email,
                    'body'=>$item->body
                ]);
                $post->num_of_comments += 1;
                $post->save();
            }
        }
    }
}
