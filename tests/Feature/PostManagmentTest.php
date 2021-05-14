<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PostManagmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_post_can_be_retrieved()
    {
        $this->withoutExceptionHandling();

        Post::factory(1)->create();

        $post = Post::first();

        $response = $this->get('/posts/'.$post->id);

        $response->assertOk();

        $response->assertViewIs('posts.show');
        $response->assertViewHas('post', $post);
    }

    /** @test */
    public function a_post_list_can_be_retrieved()
    {
        $this->withoutExceptionHandling();

        Post::factory(10)->create();

        $response = $this->get('/posts');

        $response->assertOk();

        $response->assertViewIs('posts.index');

        $posts = Post::all();
        $response->assertViewHas('posts', $posts);
    }

    /** @test */
    public function a_post_can_be_created()
    {
        $this->withoutExceptionHandling();

        $attributtes = [
            'title' => 'Test title',
            'content' => 'Test content',
        ];

        $response = $this->post('/posts', $attributtes);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertCount(1, Post::all());

        $post = Post::first();
        $this->assertEquals($attributtes['title'], $post->title);
        $this->assertEquals($attributtes['content'], $post->content);
    }

    /** @test */
    public function a_post_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $attributtes = [
            'title' => 'Test title updated',
        ];

        Post::factory(1)->create();

        $response = $this->json('PUT', '/posts/1', $attributtes);

        $response->assertStatus(Response::HTTP_OK);

        $post = $response->getOriginalContent();

        dd($post);

        $this->assertEquals($attributtes['title'], $post['title']);
    }
}
