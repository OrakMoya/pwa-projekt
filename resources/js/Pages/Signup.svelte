<script>
    import { Button } from "$lib/Shared/Components/Button";
    import * as Card from "$lib/Shared/Components/Card";
    import { Input } from "$lib/Shared/Components/Input";
    import { Label } from "$lib/Shared/Components/Label";
    import * as Alert from "$lib/Shared/Components/Alert";
    import { Link, useForm, page } from "@inertiajs/svelte";
    import { CircleAlert } from "lucide-svelte";
    import { Toaster } from "$lib/Shared/Components/Sonner";
    import { toast } from "svelte-sonner";

    let form = useForm({
        email: null,
        password: null,
        password_confirmation: null,
    });

    function processSubmit() {
        $form.post("/signup");
    }

    function processRefresh(props) {
        if (props.status) {
            toast.success(props.status);
        }
    }
    $: processRefresh($page.props);
</script>

<svelte:head>
    <title>Sign up - Newsweek</title>
</svelte:head>

<Toaster richColors />

<form on:submit|preventDefault={processSubmit}>
    <Card.Root class="w-[350px] mx-auto bg-white">
        <Card.Header>
            <Card.Title>Sign up</Card.Title>
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

            <Label for="password_confirmation">Confirm password</Label>
            <Input
                name="password_confirmation"
                type="password"
                id="password_confirmation"
                required
                bind:value={$form.password_confirmation}
            />

            {#if $page.props.errors.password}
                <Alert.Root variant="destructive" class="mt-2">
                    <CircleAlert class="h-4 w-4" />
                    <Alert.Description
                        >{$page.props.errors.password}</Alert.Description
                    >
                </Alert.Root>
            {/if}

            {#if $page.props.errors.password_confirmation}
                <Alert.Root variant="destructive" class="mt-2">
                    <CircleAlert class="h-4 w-4" />
                    <Alert.Description
                        >{$page.props.errors
                            .password_confirmation}</Alert.Description
                    >
                </Alert.Root>
            {/if}
        </Card.Content>
        <Card.Footer class="flex justify-between">
            <Button type="submit">Sign up</Button>
            <Link class="text-neutral-700 text-sm" href="/login">Login</Link>
        </Card.Footer>
    </Card.Root>
</form>
