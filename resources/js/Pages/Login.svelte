<script>
    import { Button } from "$lib/Shared/Components/Button";
    import * as Card from "$lib/Shared/Components/Card";
    import { Input } from "$lib/Shared/Components/Input";
    import { Label } from "$lib/Shared/Components/Label";
    import {Link, useForm} from "@inertiajs/svelte";

    let form = useForm({
        email: null,
        password: null
    })

    function processSubmit(){
        $form.post('/login');
    }
</script>

<form on:submit|preventDefault={processSubmit}>
    <Card.Root class="w-[350px] mx-auto bg-white">
        <Card.Header>
            <Card.Title>Login</Card.Title>
        </Card.Header>
        <Card.Content>
            <Label for="email">E-mail</Label>
            <Input name="email" type="email" id="email" required bind:value={$form.email} />

            <Label for="password">Password</Label>
            <Input name="password" type="password" id="password" required bind:value={$form.password} />
        </Card.Content>
        <Card.Footer class="flex justify-between">
            <Button type="submit">Login</Button>
            <Link class="text-neutral-700 text-sm" href="/signup">Sign up</Link>

        </Card.Footer>
    </Card.Root>
</form>
