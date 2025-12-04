<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

interface Category {
    id: number;
    name: string;
    slug: string;
    description?: string;
}

interface Tag {
    id: number;
    name: string;
    slug: string;
}

interface User {
    id: number;
    name: string;
    avatar?: string;
}

interface Post {
    id: number;
    title: string;
    slug: string;
    excerpt?: string;
    content: string;
    featured_image?: string;
    published_at: string;
    category: Category;
    user: User;
    tags: Tag[];
}

const props = defineProps<{
    post: Post;
    relatedPosts: Post[];
}>();

const breadcrumbs = computed<BreadcrumbItem[]>(() => [
    {
        title: 'Blog',
        href: '/blog',
    },
    {
        title: props.post.category.name,
        href: `/blog/category/${props.post.category.slug}`,
    },
    {
        title: props.post.title,
        href: `/blog/${props.post.slug}`,
    },
]);

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};
</script>

<template>
    <Head :title="post.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-8 overflow-x-auto rounded-xl p-4 md:p-6"
        >
            <!-- Article Header -->
            <article class="mx-auto w-full max-w-4xl">
                <div class="mb-6 flex flex-col gap-4">
                    <div class="flex flex-wrap items-center gap-3 text-sm">
                        <Link
                            :href="`/blog/category/${post.category.slug}`"
                            class="rounded-full bg-sidebar-accent px-4 py-1.5 font-medium text-sidebar-accent-foreground hover:bg-sidebar-accent/80"
                        >
                            {{ post.category.name }}
                        </Link>
                        <span class="text-sidebar-foreground/50">
                            {{ formatDate(post.published_at) }}
                        </span>
                        <span class="text-sidebar-foreground/50">•</span>
                        <span class="text-sidebar-foreground/70">
                            By {{ post.user.name }}
                        </span>
                    </div>

                    <h1
                        class="text-4xl font-bold tracking-tight text-sidebar-foreground md:text-5xl"
                    >
                        {{ post.title }}
                    </h1>

                    <p
                        v-if="post.excerpt"
                        class="text-xl text-sidebar-foreground/70"
                    >
                        {{ post.excerpt }}
                    </p>

                    <div v-if="post.tags.length > 0" class="flex flex-wrap gap-2">
                        <Link
                            v-for="tag in post.tags"
                            :key="tag.id"
                            :href="`/blog/tag/${tag.slug}`"
                            class="rounded-full border border-sidebar-border/70 px-3 py-1 text-sm text-sidebar-foreground transition-colors hover:bg-sidebar-accent dark:border-sidebar-border"
                        >
                            # {{ tag.name }}
                        </Link>
                    </div>
                </div>

                <!-- Featured Image -->
                <div
                    v-if="post.featured_image"
                    class="mb-8 aspect-video overflow-hidden rounded-xl"
                >
                    <img
                        :src="post.featured_image"
                        :alt="post.title"
                        class="h-full w-full object-cover"
                    />
                </div>

                <!-- Content -->
                <div
                    class="prose prose-lg prose-slate max-w-none dark:prose-invert prose-headings:text-sidebar-foreground prose-p:text-sidebar-foreground/80 prose-a:text-sidebar-accent-foreground prose-strong:text-sidebar-foreground prose-code:text-sidebar-foreground prose-pre:bg-sidebar-accent"
                    v-html="post.content"
                />

                <!-- Author Info -->
                <div
                    class="mt-12 flex items-center gap-4 rounded-xl border border-sidebar-border/70 bg-sidebar-accent/30 p-6 dark:border-sidebar-border"
                >
                    <div
                        class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-full bg-sidebar-accent text-2xl font-bold text-sidebar-accent-foreground"
                    >
                        {{ post.user.name.charAt(0) }}
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm text-sidebar-foreground/50">
                            Written by
                        </span>
                        <span
                            class="text-lg font-semibold text-sidebar-foreground"
                        >
                            {{ post.user.name }}
                        </span>
                    </div>
                </div>
            </article>

            <!-- Related Posts -->
            <div
                v-if="relatedPosts.length > 0"
                class="mx-auto w-full max-w-4xl"
            >
                <h2
                    class="mb-6 text-2xl font-bold text-sidebar-foreground"
                >
                    Related Posts
                </h2>

                <div class="grid gap-6 md:grid-cols-3">
                    <Link
                        v-for="relatedPost in relatedPosts"
                        :key="relatedPost.id"
                        :href="`/blog/${relatedPost.slug}`"
                        class="group flex flex-col overflow-hidden rounded-xl border border-sidebar-border/70 bg-background transition-all hover:shadow-lg dark:border-sidebar-border"
                    >
                        <div
                            class="relative aspect-video overflow-hidden bg-sidebar-accent"
                        >
                            <img
                                v-if="relatedPost.featured_image"
                                :src="relatedPost.featured_image"
                                :alt="relatedPost.title"
                                class="h-full w-full object-cover transition-transform group-hover:scale-105"
                            />
                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center bg-gradient-to-br from-sidebar-accent to-sidebar-accent-foreground/10"
                            >
                                <span
                                    class="text-3xl font-bold text-sidebar-accent-foreground/20"
                                >
                                    {{ relatedPost.title.charAt(0) }}
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 p-4">
                            <span class="text-xs text-sidebar-foreground/50">
                                {{ formatDate(relatedPost.published_at) }}
                            </span>
                            <h3
                                class="line-clamp-2 font-semibold text-sidebar-foreground group-hover:text-sidebar-accent-foreground"
                            >
                                {{ relatedPost.title }}
                            </h3>
                            <p
                                v-if="relatedPost.excerpt"
                                class="line-clamp-2 text-sm text-sidebar-foreground/70"
                            >
                                {{ relatedPost.excerpt }}
                            </p>
                        </div>
                    </Link>
                </div>
            </div>

            <!-- Back to Blog Link -->
            <div class="mx-auto w-full max-w-4xl">
                <Link
                    href="/blog"
                    class="inline-flex items-center gap-2 text-sm font-medium text-sidebar-accent-foreground hover:underline"
                >
                    ← Back to Blog
                </Link>
            </div>
        </div>
    </AppLayout>
</template>
