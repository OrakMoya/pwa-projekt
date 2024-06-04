<script>
    import { AspectRatio } from "$lib/Shared/Components/AspectRatio";
    import { Link } from "@inertiajs/svelte";
    export let post;
    let sliced_name = post.title.slice(0, 30);
    if (sliced_name.length != post.title.length) sliced_name += "...";
</script>

<svelte:head>
    <title>{sliced_name} - Newsweek</title>
</svelte:head>

<section class="max-w-screen-md mx-auto flex flex-col gap-y-2">
    <Link href="/?category={post.category}">
        <span class="text-xl font-bold text-red-500">{post.category}</span>
    </Link>
    <h1 class="text-4xl font-extrabold">{post.title}</h1>
    <span class="text-neutral-600"
        >{new Date(post.created_at).toLocaleDateString()}</span
    >
    <div class="w-full">
        <AspectRatio ratio={16 / 9} class="bg-muted-foreground">
            {#if post.feature_image}
                <img
                    src={post.feature_image}
                    alt="{post.title} image"
                    class="w-full h-full object-cover"
                />
            {/if}
        </AspectRatio>
    </div>
    <Link href="/?category={post.category}">
        <span
            class="font-bold px-4 py-1 bg-red-500 text-sm text-white w-min mb-1"
            >{post.category}</span
        >
    </Link>

    <div class="prose text-justify">
        {@html post.contents_html}
    </div>
</section>
