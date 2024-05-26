<script>
    import NavLink from "./Shared/NavLink.svelte";
    import { page } from "@inertiajs/svelte";
</script>

<header>
    <div class="bg-red-600 text-white px-10 py-2 w-full">
        <div class="flex flex-col-reverse sm:flex-row items-center sm:items-end justify-between w-full max-w-screen-xl mx-auto">
            <div class="flex flex-col-reverse text-neutral-200 basis-auto sm:basis-1/3">
                {new Date().toLocaleDateString()}
            </div>
            <div class="flex justify-center basis-1/3">
                <span class="text-6xl font-bold">Newsweek</span>
            </div>
            <div class="sm:basis-1/3"></div>
        </div>
    </div>
    <div
        class="flex justify-between px-10 py-4 max-w-screen-xl mx-auto box-content"
    >
        <nav class="flex gap-x-6">
            <NavLink href="/">Home</NavLink>
            <NavLink href="/?category={encodeURI("U.S.")}">U.S.</NavLink>
            <NavLink href="/?category={encodeURI("World")}">World</NavLink>
            <NavLink href="/admin">Administracija</NavLink>
        </nav>

        {#if $page.props.logged_in}
            <NavLink href="/logout">Log out</NavLink>
        {/if}
    </div>
</header>

<main class="bg-white w-full">
    <div class="max-w-screen-xl mx-auto box-content px-8 py-4">
        <slot />
    </div>
</main>

<footer class="p-4 text-neutral-400 border-t border-t-neutral-300 pb-20">
    <div class="max-w-screen-xl mx-auto w-full">
        <div class="border-b-neutral-300 border-b pb-4 w-full flex justify-between">
            <span>&copy;{new Date().getFullYear()} NEWSWEEK</span>
            <span>Mate Pušić</span>
        </div>
    </div>
</footer>
