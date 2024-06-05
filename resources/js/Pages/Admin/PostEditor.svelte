<script>
    import EditorJS from "@editorjs/editorjs";
    import Header from "@editorjs/header";
    import { Input } from "$lib/Shared/Components/Input";
    import { Button } from "$lib/Shared/Components/Button";
    import { Switch } from "$lib/Shared/Components/Switch";
    import { AspectRatio } from "$lib/Shared/Components/AspectRatio";
    import { useForm, page } from "@inertiajs/svelte";
    import { Eye, EyeOff, ImageUp } from "lucide-svelte";
    import { Toaster } from "$lib/Shared/Components/Sonner";
    import { toast } from "svelte-sonner";
    import edjsHTML from "editorjs-html";
    import { fade } from "svelte/transition";
    export let post;

    let data;
    if (post.contents_json) data = JSON.parse(post.contents_json);
    const editor = new EditorJS({
        tools: {
            header: Header,
        },
        data: data,
    });

    const parser = edjsHTML();

    let postForm = useForm({
        uuid: null,
        title: null,
        category: null,
        contents_json: null,
        contents_html: null,
        public: null,
        feature_image: null,
    });

    {
        $postForm.uuid = post.uuid;
        $postForm.title = post.title;
        $postForm.category = post.category;
        $postForm.public = post.public;
    }

    async function savePost() {
        const contents_objects = await editor.save();
        const contents_json = JSON.stringify(contents_objects);
        $postForm.contents_json = contents_json;

        const contents_html = parser.parse(contents_objects).join("\n");
        $postForm.contents_html = contents_html;
        console.log(contents_html);

        $postForm.post("/admin/savepost", { preserveScroll: true });
    }

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
    <title>Post editor - Newsweek Admin</title>
</svelte:head>

<Toaster richColors />

<div class="mb-4">
    <div class="w-full flex flex-col gap-y-1 max-w-screen-md mx-auto">
        <div class="flex gap-x-8 justify-between">
            <div class="flex flex-col gap-y-2 w-full">
                <Input
                    class="text-red-500 w-full text-lg font-bold bg-opacity-0 border-0"
                    placeholder="Category"
                    bind:value={$postForm.category}
                ></Input>
                <Input
                    class="text-3xl w-full font-bold border-0 bg-opacity-0"
                    placeholder="Title"
                    bind:value={$postForm.title}
                ></Input>
                <div class="px-3 py-2">
                    {new Date(post.created_at).toLocaleDateString()}
                </div>
            </div>
            <div class="flex flex-row gap-x-8 items-center">
                <div class="flex items-center gap-x-2">
                    <Switch bind:checked={$postForm.public} />

                    <div class="w-6 h-6">
                        {#if $postForm.public}
                            <div
                                transition:fade={{ duration: 100 }}
                                class="absolute w-6 h-6"
                            >
                                <Eye class="" />
                            </div>
                        {:else}
                            <div
                                transition:fade={{ duration: 100 }}
                                class="absolute w-6 h-6"
                            >
                                <EyeOff class="" />
                            </div>
                        {/if}
                    </div>
                </div>
                <Button on:click={savePost}>Save</Button>
            </div>
        </div>

        <input
            type="file"
            id="feature_image"
            accept="image/*"
            class="hidden"
            on:input={(e) => ($postForm.feature_image = e.target.files[0])}
        />
        <label for="feature_image">
            <div
                class="max-w-screen-md w-full mx-auto hover:brightness-110 transition duration-300"
            >
                {#if post.feature_image || $postForm.feature_image}
                    <AspectRatio
                        ratio={16 / 9}
                        class="bg-muted-foreground rounded-md overflow-clip"
                    >
                        <img
                            src={$postForm.feature_image
                                ? URL.createObjectURL($postForm.feature_image)
                                : post.feature_image}
                            alt="Feature"
                            class="object-cover w-full h-full overflow-clip"
                        />
                    </AspectRatio>
                {:else}
                    <AspectRatio
                        ratio={2.35}
                        class="bg-muted-foreground rounded-xl transition-all hover:rounded-md duration-300 overflow-clip"
                    >
                        <div
                            class="flex justify-center items-center w-full h-full"
                        >
                            <ImageUp
                                class="w-20 h-20 text-white drop-shadow-md"
                            />
                        </div>
                    </AspectRatio>
                {/if}
            </div>
        </label>
    </div>
</div>

<div class="w-full max-w-screen-md mx-auto rounded-md overflow-clip border">
    <div
        class="prose text-justify whitespace-pre overflow-x-auto break-normal text-wrap min-w-full w-full max-w-auto py-4 px-4"
    >
        <div id="editorjs" class="max-w-auto w-full"></div>
    </div>
</div>
