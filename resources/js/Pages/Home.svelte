<script>
    import { AspectRatio } from "$lib/Shared/Components/AspectRatio";
    import { Link } from "@inertiajs/svelte";

    export let posts;
</script>

<section class="border-t border-t-neutral-300 pt-4">
    <h2 class="text-red-500 font-bold mb-2">U.S.</h2>
    <div class="grid grid-cols-3 w-full gap-4">
        {#each posts as post}
            <Link href="/view/{post.id}">
                <div>
                    <div class="w-full overflow-clip mb-1">
                        <AspectRatio
                            ratio={16 / 10}
                            class="bg-muted-foreground"
                        />
                    </div>
                    <span class="font-bold">{post.title}</span>
                </div>
            </Link>
        {/each}
    </div>
</section>
