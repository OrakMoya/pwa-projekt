<script>
    import { Button } from "$lib/Shared/Components/Button";
    import { Input } from "$lib/Shared/Components/Input";
    import { AspectRatio } from "$lib/Shared/Components/AspectRatio";
    import { Eye, Pen, Pencil, Plus, Trash2 } from "lucide-svelte";
    import { Link, router, useForm, page } from "@inertiajs/svelte";
    import * as Dialog from "$lib/Shared/Components/Dialog";
    import { Toaster } from "$lib/Shared/Components/Sonner";
    import { Checkbox } from "$lib/Shared/Components/Checkbox";
    import { Label } from "$lib/Shared/Components/Label";
    import * as AlertDialog from "$lib/Shared/Components/AlertDialog";
    import { toast } from "svelte-sonner";

    let createPostForm = useForm({
        title: null,
        category: null,
        openeditor: true,
    });

    let dialog_open = false;

    function processCreatePost() {
        $createPostForm.post("/admin/createpost", {
            onSuccess: () => (dialog_open = false),
            preserveScroll: true,
        });
    }
    export let posts;

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
</script>

<svelte:head>
    <title>Posts - Newsweek Admin</title>
</svelte:head>

<Toaster richColors />

<div class="">
    <div class="flex gap-x-4 items-center justify-between pb-4">
        <h2 class="text-3xl">Posts</h2>

        <Dialog.Root bind:open={dialog_open}>
            <Dialog.Content>
                <form on:submit|preventDefault={processCreatePost}>
                    <Dialog.Header class="mb-4">
                        <Dialog.Title>New post</Dialog.Title>
                        <Dialog.Description
                            >Posts are hidden by default.</Dialog.Description
                        >
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
                        <div class="flex items-center gap-x-1">
                            <Checkbox
                                class="rounded-md"
                                bind:checked={$createPostForm.openeditor}
                                id="openeditor"
                            />
                            <Label for="openeditor">Open editor</Label>
                        </div>
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
        {#each posts as post, i}
            <div
                class="flex items-center justify-between mb-4 rounded-md overflow-clip"
            >
                <div
                    class="flex items-center gap-x-2 w-full"
                    style={i % 2 == 1
                        ? " background: rgb45,245,245); background: linear-gradient(90deg, rgba(245,245,245,1) 80%, rgba(245,245,245,0) 100%); "
                        : ""}
                >
                    <div class="w-28 bg-red-100 rounded-md overflow-clip">
                        <AspectRatio ratio={16 / 9} class="bg-muted-foreground">
                            <div class="w-full h-full">
                                {#if post.feature_image}
                                    <img
                                        src={post.feature_image}
                                        alt="{post.title} image"
                                        class="w-full h-full object-cover"
                                    />
                                {/if}
                            </div>
                            <div
                                class="opacity-0 z-10 -translate-y-full transition-opacity text-white drop-shadow-md hover:opacity-100 absolute w-full h-full flex flex-row justify-center items-center bg-black bg-opacity-30"
                            >
                                <Link href="/view/{post.uuid}"><Eye /></Link>
                                <div
                                    class="h-2/3 border-l mx-4 border-neutral-100"
                                ></div>
                                <Link href="/admin/editpost/{post.uuid}"
                                    ><Pencil /></Link
                                >
                            </div>
                        </AspectRatio>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="text-lg font-bold">{post.title}</h3>
                        <span class="text-sm text-red-500">{post.category}</span
                        >
                    </div>
                </div>
                <div class="flex gap-x-4">
                    <Link href="/admin/editpost/{post.uuid}">
                        <Button><Pencil class="w-4 h-4" /></Button>
                    </Link>
                    <AlertDialog.Root>
                        <AlertDialog.Trigger asChild let:builder>
                            <Button variant="destructive" builders={[builder]}>
                                <Trash2 class="w-4 h-4" />
                            </Button>
                        </AlertDialog.Trigger>
                        <AlertDialog.Content>
                            <AlertDialog.Header>
                                <AlertDialog.Title
                                    >Are you sure?</AlertDialog.Title
                                >
                            </AlertDialog.Header>
                            <AlertDialog.Footer>
                                <AlertDialog.Cancel>Cancel</AlertDialog.Cancel>
                                <AlertDialog.Action
                                    on:click={() =>
                                        router.visit("/admin/deletepost", {
                                            method: "post",
                                            preserveScroll: true,
                                            data: {
                                                uuid: post.uuid,
                                            },
                                        })}>Continue</AlertDialog.Action
                                >
                            </AlertDialog.Footer>
                        </AlertDialog.Content>
                    </AlertDialog.Root>
                </div>
            </div>
        {/each}
    </section>
</div>
