<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use function Pest\Laravel\get;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->category = Category::factory()->create(['name' => 'Technology', 'slug' => 'technology']);
    $this->tag = Tag::factory()->create(['name' => 'Laravel', 'slug' => 'laravel']);
});

test('blog index page displays published posts', function () {
    $publishedPost = Post::factory()->published()->create([
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
    ]);
    $draftPost = Post::factory()->draft()->create([
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
    ]);

    get(route('blog.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Blog/Index')
            ->has('posts.data', 1)
            ->where('posts.data.0.id', $publishedPost->id));
});

test('blog index page does not display draft posts', function () {
    $draftPost = Post::factory()->draft()->create([
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
    ]);

    get(route('blog.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Blog/Index')
            ->has('posts.data', 0));
});

test('blog show page displays published post', function () {
    $post = Post::factory()->published()->create([
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
        'slug' => 'test-post',
    ]);

    get(route('blog.show', ['slug' => 'test-post']))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Blog/Show')
            ->where('post.id', $post->id)
            ->where('post.title', $post->title));
});

test('blog show page returns 404 for draft posts', function () {
    $post = Post::factory()->draft()->create([
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
        'slug' => 'draft-post',
    ]);

    get(route('blog.show', ['slug' => 'draft-post']))
        ->assertNotFound();
});

test('blog show page returns 404 for non-existent posts', function () {
    get(route('blog.show', ['slug' => 'non-existent']))
        ->assertNotFound();
});

test('blog category page filters posts by category', function () {
    $otherCategory = Category::factory()->create(['slug' => 'design']);

    $technologyPost = Post::factory()->published()->create([
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
    ]);

    $designPost = Post::factory()->published()->create([
        'user_id' => $this->user->id,
        'category_id' => $otherCategory->id,
    ]);

    get(route('blog.category', ['slug' => 'technology']))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Blog/Index')
            ->has('posts.data', 1)
            ->where('posts.data.0.id', $technologyPost->id)
            ->where('currentCategory.id', $this->category->id));
});

test('blog tag page filters posts by tag', function () {
    $otherTag = Tag::factory()->create(['slug' => 'php']);

    $laravelPost = Post::factory()->published()->create([
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
    ]);
    $laravelPost->tags()->attach($this->tag);

    $phpPost = Post::factory()->published()->create([
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
    ]);
    $phpPost->tags()->attach($otherTag);

    get(route('blog.tag', ['slug' => 'laravel']))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Blog/Index')
            ->has('posts.data', 1)
            ->where('posts.data.0.id', $laravelPost->id)
            ->where('currentTag.id', $this->tag->id));
});

test('blog show page displays related posts from same category', function () {
    $mainPost = Post::factory()->published()->create([
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
        'slug' => 'main-post',
    ]);

    $relatedPost1 = Post::factory()->published()->create([
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
    ]);

    $relatedPost2 = Post::factory()->published()->create([
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
    ]);

    $otherCategoryPost = Post::factory()->published()->create([
        'user_id' => $this->user->id,
        'category_id' => Category::factory()->create()->id,
    ]);

    get(route('blog.show', ['slug' => 'main-post']))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Blog/Show')
            ->has('relatedPosts', 2));
});

test('post model has correct relationships', function () {
    $post = Post::factory()->create([
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
    ]);
    $post->tags()->attach($this->tag);

    expect($post->user)->toBeInstanceOf(User::class)
        ->and($post->category)->toBeInstanceOf(Category::class)
        ->and($post->tags)->toHaveCount(1)
        ->and($post->tags->first())->toBeInstanceOf(Tag::class);
});

test('category model counts posts correctly', function () {
    Post::factory()->count(3)->published()->create([
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
    ]);

    $category = Category::withCount('posts')->find($this->category->id);

    expect($category->posts_count)->toBe(3);
});

test('tag model counts posts correctly', function () {
    $posts = Post::factory()->count(2)->published()->create([
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
    ]);

    foreach ($posts as $post) {
        $post->tags()->attach($this->tag);
    }

    $tag = Tag::withCount('posts')->find($this->tag->id);

    expect($tag->posts_count)->toBe(2);
});
