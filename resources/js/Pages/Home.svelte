<script>
    import { AspectRatio } from "$lib/Shared/Components/AspectRatio";
    import { Link } from "@inertiajs/svelte";
    import { page } from "@inertiajs/svelte";
    import { fade } from "svelte/transition";

    export let posts_by_categories;
    console.log(posts_by_categories);
</script>

{#each posts_by_categories as category}
    <section class="border-t border-t-neutral-300 pt-4 mb-4">
        <h2 class="text-red-500 font-bold mb-2">{category.name}</h2>
        <div class="grid grid-cols-3 w-full gap-4">
            {#each category.posts as post}
                <Link href="/view/{post.uuid}">
                    <div>
                        <div class="w-full overflow-clip mb-1">
                            <AspectRatio
                                ratio={16 / 10}
                                class="bg-muted-foreground"
                            >
                                {#if post.feature_image}
                                    <img
                                        class="w-full h-full object-cover"
                                        src={post.feature_image}
                                        alt="{post.title} image"
                                    />
                                {/if}
                            </AspectRatio>
                        </div>
                        <span class="font-extrabold">{post.title}</span>
                    </div>
                </Link>
            {/each}
        </div>
    </section>
{/each}
