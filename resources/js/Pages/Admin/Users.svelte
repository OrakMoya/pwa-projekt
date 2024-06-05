<script>
    import { Link, page, router, useForm } from "@inertiajs/svelte";
    import { Button } from "$lib/Shared/Components/Button";
    import { Input } from "$lib/Shared/Components/Input";
    import { Label } from "$lib/Shared/Components/Label";
    import * as AlertDialog from "$lib/Shared/Components/AlertDialog";
    import * as Dialog from "$lib/Shared/Components/Dialog";
    import * as Accordion from "$lib/Shared/Components/Accordion";
    import { Trash2, Pencil } from "lucide-svelte";
    import { Toaster } from "$lib/Shared/Components/Sonner";
    import { toast } from "svelte-sonner";
    export let users;
    export let current_user;

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

    let updateUserForm = useForm({
        id: null,
        name: null,
    });
    let updateUserPasswordForm = useForm({
        id: null,
        password: null,
        password_confirmation: null,
    });
</script>

<svelte:head>
    <title>Users - Newsweek Admin</title>
</svelte:head>

<Toaster richColors />

<div class="flex flex-col">
    <h2 class="text-3xl pb-4">Users</h2>

    <section class="border-b border-b-neutral-300">
        {#each users as user, i}
            <div class="flex items-center justify-between mb-4">
                <div
                    class="flex items-center gap-x-2 w-full p-2 rounded-md overflow-clip"
                    style={i % 2 == 1
                        ? " background: rgb45,245,245); background: linear-gradient(90deg, rgba(245,245,245,1) 80%, rgba(245,245,245,0) 100%); "
                        : ""}
                >
                    <div class="flex flex-col">
                        <h3 class="text-lg drop-shadow-sm font-semibold">
                            {user.email}
                        </h3>
                        {#if user.name}
                            <span class="text-base">{user.name}</span>
                        {/if}
                    </div>
                </div>
                <div class="flex gap-x-4">
                    <Dialog.Root>
                        <Dialog.Trigger asChild let:builder>
                            <Button
                                builders={[builder]}
                                on:click={() => {
                                    $updateUserForm.id = user.id;
                                    $updateUserForm.name = user.name;
                                    $updateUserPasswordForm.id = user.id;
                                }}><Pencil class="w-4 h-4" /></Button
                            >
                        </Dialog.Trigger>
                        <Dialog.Content>
                            <Dialog.Title>Update user information</Dialog.Title>
                            <form
                                on:submit|preventDefault={() =>
                                    $updateUserForm.post("/admin/updateuser")}
                            >
                                <Label for="user-name-{user.id}">Name</Label>
                                <Input
                                    bind:value={$updateUserForm.name}
                                    id="user-name-{user.id}"
                                />
                                <Label for="user-email-{user.id}">Email</Label>
                                <Input
                                    bind:value={user.email}
                                    id="user-email-{user.id}"
                                    disabled
                                />
                                <Button class="mt-4" type="submit">Save</Button>
                            </form>

                            <Accordion.Root>
                                <Accordion.Item
                                    value="item-1"
                                    class="border-b-0"
                                >
                                    <Accordion.Trigger class="pt-2"
                                        >Change password</Accordion.Trigger
                                    >
                                    <Accordion.Content class="overflow-visible">
                                        <form
                                            on:submit|preventDefault={$updateUserPasswordForm.post(
                                                "/admin/updatepassword",
                                                { preserveScroll: true },
                                            )}
                                        >
                                            <Label for="user-password-{user.id}"
                                                >Password</Label
                                            >
                                            <Input
                                                bind:value={$updateUserPasswordForm.password}
                                                type="password"
                                                id="user-password-{user.id}"
                                            />

                                            <Label
                                                bind:value={updateUserPasswordForm.password_confirmation}
                                                for="user-password-confirmation-{user.id}"
                                                >Confirm password</Label
                                            >
                                            <Input
                                                type="password"
                                                id="user-password-confirmation-{user.id}"
                                                bind:value={$updateUserPasswordForm.password_confirmation}
                                            />
                                            <Button class="mt-4" type="submit"
                                                >Change password</Button
                                            >
                                        </form>
                                    </Accordion.Content>
                                </Accordion.Item>
                            </Accordion.Root>
                        </Dialog.Content>
                    </Dialog.Root>

                    <AlertDialog.Root>
                        <AlertDialog.Trigger asChild let:builder>
                            <Button
                                variant="destructive"
                                disabled={user.email === current_user}
                                builders={[builder]}
                            >
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
                                        router.visit("/admin/deleteuser", {
                                            method: "post",
                                            preserveScroll: true,
                                            data: {
                                                id: user.id,
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
