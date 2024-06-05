<script>
    import { Button } from "$lib/Shared/Components/Button";
    import * as Card from "$lib/Shared/Components/Card";
    import { Input } from "$lib/Shared/Components/Input";
    import { Label } from "$lib/Shared/Components/Label";
    import { Checkbox } from "$lib/Shared/Components/Checkbox";
    import * as Alert from "$lib/Shared/Components/Alert";
    import { Link, useForm, page, remember } from "@inertiajs/svelte";
    import { CircleAlert } from "lucide-svelte";
    import { Toaster } from "$lib/Shared/Components/Sonner";
    import { toast } from "svelte-sonner";

    let form = useForm({
        email: null,
        password: null,
        rememberme: null,
    });

    function processSubmit() {
        $form.post("/login");
    }

    function processRefresh(props) {
        if (props.status) {
            toast.success(props.status);
        }
    }
    $: processRefresh($page.props);
</script>

<svelte:head>
    <title>Login - Newsweek</title>
</svelte:head>

<Toaster richColors />

<form on:submit|preventDefault={processSubmit}>
    <Card.Root class="w-[350px] mx-auto bg-white">
        <Card.Header>
            <Card.Title>Login</Card.Title>
        </Card.Header>
        <Card.Content>
            <Label for="email">E-mail</Label>
            <Input
                name="email"
                type="email"
                id="email"
                required
                bind:value={$form.email}
            />

            {#if $page.props.errors.email}
                <Alert.Root variant="destructive" class="mt-2">
                    <CircleAlert class="h-4 w-4" />
                    <Alert.Description
                        >{$page.props.errors.email}</Alert.Description
                    >
                </Alert.Root>
            {/if}

            <Label for="password">Password</Label>
            <Input
                name="password"
                type="password"
                id="password"
                required
                bind:value={$form.password}
            />
            {#if $page.props.errors.password}
                <Alert.Root variant="destructive" class="mt-2">
                    <CircleAlert class="h-4 w-4" />
                    <Alert.Description
                        >{$page.props.errors.password}</Alert.Description
                    >
                </Alert.Root>
            {/if}
            <div class="flex gap-x-2 mt-4">
                <Checkbox class="rounded-md" bind:checked={$form.rememberme} id="rememberme" />
                <Label for="rememberme">Remember me</Label>
            </div>
        </Card.Content>
        <Card.Footer class="flex justify-between">
            <Button type="submit">Login</Button>

            <Link class="text-neutral-700 text-sm" href="/signup">Sign up</Link>
        </Card.Footer>
    </Card.Root>
</form>
