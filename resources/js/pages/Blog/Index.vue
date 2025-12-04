<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';

interface Category {
    id: number;
    name: string;
    slug: string;
    description?: string;
    posts_count?: number;
}

interface Tag {
    id: number;
    name: string;
    slug: string;
    posts_count?: number;
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

interface PaginatedPosts {
    data: Post[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    links: Array<{
        url: string | null;
        label: string;
        active: boolean;
    }>;
}

const props = defineProps<{
    posts: PaginatedPosts;
    categories: Category[];
    popularTags: Tag[];
    currentCategory?: Category;
    currentTag?: Tag;
}>();

const breadcrumbs = computed<BreadcrumbItem[]>(() => {
    const items: BreadcrumbItem[] = [
        {
            title: 'Blog',
            href: '/blog',
        },
    ];

    if (props.currentCategory) {
        items.push({
            title: props.currentCategory.name,
            href: `/blog/category/${props.currentCategory.slug}`,
        });
    }

    if (props.currentTag) {
        items.push({
            title: props.currentTag.name,
            href: `/blog/tag/${props.currentTag.slug}`,
        });
    }

    return items;
});

const pageTitle = computed(() => {
    if (props.currentCategory) {
        return `${props.currentCategory.name} - Blog`;
    }
    if (props.currentTag) {
        return `${props.currentTag.name} - Blog`;
    }
    return 'Blog';
});

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};
</script>

<template>
    <Head :title="pageTitle" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4 md:p-6"
        >
            <!-- Header -->
            <div class="flex flex-col gap-2">
                <h1
                    class="text-3xl font-bold tracking-tight text-sidebar-foreground"
                >
                    {{ pageTitle }}
                </h1>
                <p
                    v-if="currentCategory?.description"
                    class="text-sidebar-foreground/70"
                >
                    {{ currentCategory.description }}
                </p>
            </div>

            <div class="grid gap-6 lg:grid-cols-12">
                <!-- Main Content -->
                <div class="lg:col-span-8">
                    <!-- Posts Grid -->
                    <div
                        v-if="posts.data.length > 0"
                        class="grid gap-6 md:grid-cols-2"
                    >
                        <article
                            v-for="post in posts.data"
                            :key="post.id"
                            class="group flex flex-col overflow-hidden rounded-xl border border-sidebar-border/70 bg-background transition-all hover:shadow-lg dark:border-sidebar-border"
                        >
                            <Link
                                :href="`/blog/${post.slug}`"
                                class="relative aspect-video overflow-hidden bg-sidebar-accent"
                            >
                                <img
                                    v-if="post.featured_image"
                                    :src="post.featured_image"
                                    :alt="post.title"
                                    class="h-full w-full object-cover transition-transform group-hover:scale-105"
                                />
                                <div
                                    v-else
                                    class="flex h-full w-full items-center justify-center bg-gradient-to-br from-sidebar-accent to-sidebar-accent-foreground/10"
                                >
                                    <span
                                        class="text-4xl font-bold text-sidebar-accent-foreground/20"
                                    >
                                        {{ post.title.charAt(0) }}
                                    </span>
                                </div>
                            </Link>

                            <div class="flex flex-1 flex-col gap-3 p-5">
                                <div class="flex items-center gap-2 text-sm">
                                    <Link
                                        :href="`/blog/category/${post.category.slug}`"
                                        class="rounded-full bg-sidebar-accent px-3 py-1 font-medium text-sidebar-accent-foreground hover:bg-sidebar-accent/80"
                                    >
                                        {{ post.category.name }}
                                    </Link>
                                    <span
                                        class="text-sidebar-foreground/50"
                                    >
                                        {{ formatDate(post.published_at) }}
                                    </span>
                                </div>

                                <Link
                                    :href="`/blog/${post.slug}`"
                                    class="group/title"
                                >
                                    <h2
                                        class="text-xl font-bold text-sidebar-foreground group-hover/title:text-sidebar-accent-foreground"
                                    >
                                        {{ post.title }}
                                    </h2>
                                </Link>

                                <p
                                    v-if="post.excerpt"
                                    class="line-clamp-3 flex-1 text-sidebar-foreground/70"
                                >
                                    {{ post.excerpt }}
                                </p>

                                <div
                                    class="flex items-center justify-between pt-2"
                                >
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-sidebar-accent text-sm font-medium text-sidebar-accent-foreground"
                                        >
                                            {{ post.user.name.charAt(0) }}
                                        </div>
                                        <span
                                            class="text-sm text-sidebar-foreground/70"
                                        >
                                            {{ post.user.name }}
                                        </span>
                                    </div>

                                    <Link
                                        :href="`/blog/${post.slug}`"
                                        class="text-sm font-medium text-sidebar-accent-foreground hover:underline"
                                    >
                                        Read more →
                                    </Link>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Empty State -->
                    <div
                        v-else
                        class="flex flex-col items-center justify-center rounded-xl border border-sidebar-border/70 bg-background p-12 text-center dark:border-sidebar-border"
                    >
                        <h3
                            class="mb-2 text-lg font-semibold text-sidebar-foreground"
                        >
                            No posts found
                        </h3>
                        <p class="text-sidebar-foreground/70">
                            Check back later for new content!
                        </p>
                    </div>

                    <!-- Pagination -->
                    <div
                        v-if="posts.last_page > 1"
                        class="mt-6 flex justify-center gap-2"
                    >
                        <template
                            v-for="(link, index) in posts.links"
                            :key="index"
                        >
                            <Link
                                v-if="link.url"
                                :href="link.url"
                                class="rounded-lg border border-sidebar-border/70 px-4 py-2 text-sm font-medium transition-colors hover:bg-sidebar-accent dark:border-sidebar-border"
                                :class="{
                                    'bg-sidebar-accent text-sidebar-accent-foreground':
                                        link.active,
                                    'text-sidebar-foreground': !link.active,
                                }"
                                v-html="link.label"
                            />
                            <span
                                v-else
                                class="rounded-lg border border-sidebar-border/70 px-4 py-2 text-sm font-medium text-sidebar-foreground/50 dark:border-sidebar-border"
                                v-html="link.label"
                            />
                        </template>
                    </div>
                </div>

                <!-- Sidebar -->
                <aside class="lg:col-span-4">
                    <div class="sticky top-6 flex flex-col gap-6">
                        <!-- Categories -->
                        <div
                            class="rounded-xl border border-sidebar-border/70 bg-background p-5 dark:border-sidebar-border"
                        >
                            <h3
                                class="mb-4 text-lg font-semibold text-sidebar-foreground"
                            >
                                Categories
                            </h3>
                            <div class="flex flex-col gap-2">
                                <Link
                                    v-for="category in categories"
                                    :key="category.id"
                                    :href="`/blog/category/${category.slug}`"
                                    class="flex items-center justify-between rounded-lg px-3 py-2 text-sm transition-colors hover:bg-sidebar-accent"
                                    :class="{
                                        'bg-sidebar-accent font-medium text-sidebar-accent-foreground':
                                            currentCategory?.id === category.id,
                                        'text-sidebar-foreground':
                                            currentCategory?.id !== category.id,
                                    }"
                                >
                                    <span>{{ category.name }}</span>
                                    <span
                                        v-if="category.posts_count"
                                        class="text-xs text-sidebar-foreground/50"
                                    >
                                        {{ category.posts_count }}
                                    </span>
                                </Link>
                            </div>
                        </div>

                        <!-- Popular Tags -->
                        <div
                            v-if="popularTags.length > 0"
                            class="rounded-xl border border-sidebar-border/70 bg-background p-5 dark:border-sidebar-border"
                        >
                            <h3
                                class="mb-4 text-lg font-semibold text-sidebar-foreground"
                            >
                                Popular Tags
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                <Link
                                    v-for="tag in popularTags"
                                    :key="tag.id"
                                    :href="`/blog/tag/${tag.slug}`"
                                    class="rounded-full border border-sidebar-border/70 px-3 py-1 text-sm transition-colors hover:bg-sidebar-accent dark:border-sidebar-border"
                                    :class="{
                                        'bg-sidebar-accent font-medium text-sidebar-accent-foreground':
                                            currentTag?.id === tag.id,
                                        'text-sidebar-foreground':
                                            currentTag?.id !== tag.id,
                                    }"
                                >
                                    {{ tag.name }}
                                </Link>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </AppLayout>
</template>
