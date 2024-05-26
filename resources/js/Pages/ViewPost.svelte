<script>
    import { AspectRatio } from "$lib/Shared/Components/AspectRatio";
    export let post;
</script>

<section class="max-w-screen-md mx-auto flex flex-col gap-y-2">
    <span class="text-xl font-bold text-red-500">{post.category}</span>
    <h1 class="text-4xl font-extrabold">{post.title}</h1>
    <span class="text-neutral-500 text-sm"
        >{new Date(post.created_at).toLocaleDateString()}</span
    >
    <div class="w-full">
        <AspectRatio ratio={16 / 9} class="bg-muted-foreground"></AspectRatio>
    </div>
    <span class="font-bold px-4 py-1 bg-red-500 text-sm text-white w-min mb-1"
        >{post.category}</span
    >
    <div class="prose text-justify">
        {@html post.contents_html}
    </div>
</section>
