<script>
    import { AspectRatio } from "$lib/Shared/Components/AspectRatio";
    import { Link } from "@inertiajs/svelte";
    import { page } from "@inertiajs/svelte";
    import { fade } from "svelte/transition";
    import { Toaster } from "$lib/Shared/Components/Sonner";
    import { toast } from "svelte-sonner";

    function processRefresh(props) {
        if (JSON.stringify(props.errors) !== "{}") {
            for (const [key, value] of Object.entries(props.errors)) {
                toast.error(value);
            }
        } else if (props.status) {
            toast.success(props.status);
        }
    }
    $: processRefresh($page.props);

    export let posts_by_categories;
    export let category;
</script>

<svelte:head>
    {#key category}
        {#if category}
            <title>{category} - Newsweek</title>
        {:else}
            <title>Newsweek</title>
        {/if}
    {/key}
</svelte:head>

<Toaster richColors />

{#each posts_by_categories as category, i}
    <section class="{i!==0 ? 'border-t pt-4' : ''} border-t-neutral-300 mb-4">
        <h2 class="text-red-500 font-bold mb-2">
            <Link href="/?category={category.name}">{category.name}</Link>
        </h2>
        <div class="grid grid-cols-3 w-full gap-6">
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
                        <div class="font-bold text-justify text-xl">
                            {post.title}
                        </div>
                    </div>
                </Link>
            {/each}
        </div>
    </section>
{/each}
