<script>
    import { Link, page, router, useForm } from "@inertiajs/svelte";
    import { Button } from "$lib/Shared/Components/Button";
    import { Input } from "$lib/Shared/Components/Input";
    import { Label } from "$lib/Shared/Components/Label";
    import * as AlertDialog from "$lib/Shared/Components/AlertDialog";
    import * as Dialog from "$lib/Shared/Components/Dialog";
    import * as Accordion from "$lib/Shared/Components/Accordion";
    import { Trash2, Pencil, Lock } from "lucide-svelte";
    import { Toaster } from "$lib/Shared/Components/Sonner";
    import * as Select from "$lib/Shared/Components/Select";
    import { toast } from "svelte-sonner";
    export let users;
    export let current_user;
    export let available_privileges;

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
        privilege_level: null,
    });
    let updateUserPasswordForm = useForm({
        id: null,
        password: null,
        password_confirmation: null,
    });

    $: selected_privilege_level = {
        label: capitalizeFirstLetter($updateUserForm.privilege_level),
        value: $updateUserForm.privilege_level,
    };

    function capitalizeFirstLetter(string) {
        if (string) return string.charAt(0).toUpperCase() + string.slice(1);
    }
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
                                disabled={(current_user.email != user.email &&
                                    current_user.privilege_level !=
                                        "administrator") ||
                                    user.read_only}
                                on:click={() => {
                                    $updateUserForm.id = user.id;
                                    $updateUserForm.name = user.name;
                                    $updateUserForm.privilege_level =
                                        user.privilege_level;
                                    selected_privilege_level = {
                                        name: user.privilege_level,
                                        value: user.privilege_level,
                                    };
                                    $updateUserPasswordForm.id = user.id;
                                }}
                            >
                                {#if user.read_only}
                                    <Lock class="w-4 h-4" />
                                {:else}
                                    <Pencil class="w-4 h-4" />
                                {/if}
                            </Button>
                        </Dialog.Trigger>
                        <Dialog.Content>
                            <Dialog.Title>Update user information</Dialog.Title>
                            <form
                                on:submit|preventDefault={() =>
                                    $updateUserForm.post("/admin/updateuser")}
                            >
                                <Label for="user-name-{user.id}">Name</Label>
                                <Input
                                    disabled={(current_user.email !=
                                        user.email &&
                                        current_user.privilege_level !=
                                            "administrator") ||
                                        user.read_only}
                                    bind:value={$updateUserForm.name}
                                    id="user-name-{user.id}"
                                />
                                <Label for="user-email-{user.id}">Email</Label>
                                <Input
                                    bind:value={user.email}
                                    id="user-email-{user.id}"
                                    disabled
                                />
                                <Label for="privilege-level-{user.id}"
                                    >Privilege level</Label
                                >
                                <Select.Root
                                    portal={null}
                                    selected={selected_privilege_level}
                                    onSelectedChange={(v) =>
                                        v &&
                                        ($updateUserForm.privilege_level =
                                            v.value)}
                                >
                                    <Select.Trigger
                                        disabled={current_user.privilege_level !==
                                            "administrator" || user.read_only}
                                        id="privilege-level-{user.id}"
                                        class="w-[180px]"
                                    >
                                        <Select.Value
                                            placeholder={user.privilege_level}
                                        />
                                    </Select.Trigger>
                                    <Select.Content>
                                        <Select.Group>
                                            {#each available_privileges as available_privilege_level}
                                                <Select.Item
                                                    value={available_privilege_level}
                                                    label={capitalizeFirstLetter(
                                                        available_privilege_level,
                                                    )}
                                                />
                                            {/each}
                                        </Select.Group>
                                    </Select.Content>
                                </Select.Root>
                                <input
                                    hidden
                                    bind:value={$updateUserForm.privilege_level}
                                    name="privilege-level-{user.id}"
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
                                                disabled={(current_user.email !=
                                                    user.email &&
                                                    current_user.privilege_level !=
                                                        "administrator") ||
                                                    user.read_only}
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
                                                disabled={(current_user.email !=
                                                    user.email &&
                                                    current_user.privilege_level !=
                                                        "administrator") ||
                                                    user.read_only}
                                                id="user-password-confirmation-{user.id}"
                                                bind:value={$updateUserPasswordForm.password_confirmation}
                                            />
                                            <Button
                                                class="mt-4"
                                                type="submit"
                                                disabled={(current_user.email !=
                                                    user.email &&
                                                    current_user.privilege_level !=
                                                        "administrator") ||
                                                    user.read_only}
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
                                disabled={(current_user.email != user.email &&
                                    current_user.privilege_level !=
                                        "administrator") ||
                                    user.read_only}
                                variant="destructive"
                                builders={[builder]}
                            >
                                {#if user.read_only}
                                    <Lock class="w-4 h-4" />
                                {:else}
                                    <Trash2 class="w-4 h-4" />
                                {/if}
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
                                    disabled={(current_user.email !=
                                        user.email &&
                                        current_user.privilege_level !=
                                            "administrator") ||
                                        user.read_only}
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
