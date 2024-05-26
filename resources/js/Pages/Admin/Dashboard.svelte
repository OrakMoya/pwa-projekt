<script>
    import { Button } from "$lib/Shared/Components/Button";
    import { Input } from "$lib/Shared/Components/Input";
    import { AspectRatio } from "$lib/Shared/Components/AspectRatio";
    import { Pencil, Plus, Trash2 } from "lucide-svelte";
    import { Link, router, useForm } from "@inertiajs/svelte";
    import * as Dialog from "$lib/Shared/Components/Dialog";

    let createPostForm = useForm({
        title: null,
        category: null,
    });

    let dialog_open = false;

    function processCreatePost() {
        $createPostForm.post("/admin/createpost", {
            onSuccess: () => (dialog_open = false),
        });
    }

    export let posts;
</script>

<div class="flex flex-col">
    <div class="flex gap-x-4 items-center justify-between pb-4">
        <h2 class="text-xl">Najnovije objave</h2>

        <Dialog.Root bind:open={dialog_open}>
            <Dialog.Content>
                <form on:submit|preventDefault={processCreatePost}>
                    <Dialog.Header class="mb-4">
                        <Dialog.Title>New post</Dialog.Title>
                    </Dialog.Header>

                    <div class="flex flex-col gap-y-3">
                        <Input
                            placeholder="Title"
                            bind:value={$createPostForm.title}
                        ></Input>
                        <Input
                            placeholder="Category"
                            bind:value={$createPostForm.category}
                        ></Input>
                    </div>

                    <Dialog.Footer class="mt-4">
                        <Button
                            on:click={() => (dialog_open = false)}
                            variant="ghost">Close</Button
                        >
                        <Button type="submit">Save</Button>
                    </Dialog.Footer>
                </form>
            </Dialog.Content>
        </Dialog.Root>

        <Button on:click={() => (dialog_open = true)}
            ><Plus class="w-4 h-4" /></Button
        >
    </div>

    <section class="border-b border-b-neutral-300">
        {#each posts as post}
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-x-2">
                    <div class="w-28 bg-red-100 rounded-md overflow-clip">
                        <AspectRatio ratio={16 / 9} class="bg-muted-foreground"
                        ></AspectRatio>
                    </div>
                    <h3 class="text-lg">{post.title}</h3>
                </div>
                <div class="flex gap-x-4">
                    <Link href="/admin/editpost/{post.uuid}">
                        <Button><Pencil class="w-4 h-4" /></Button>
                    </Link>
                    <Button
                        variant="destructive"
                        on:click={() =>
                            router.visit("/admin/deletepost", {
                                method: "post",
                                data: { id: post.uuid },
                            })}
                    >
                        <Trash2 class="w-4 h-4" />
                    </Button>
                </div>
            </div>
        {/each}
    </section>
</div>
