<script>
    import NavLink from "./Shared/NavLink.svelte";
    import { page } from "@inertiajs/svelte";
</script>

<header>
    <div class="grid grid-cols-3 w-full py-2 bg-red-600 text-white px-10">
        <div class="flex flex-col-reverse text-neutral-200">
            {new Date().toLocaleDateString()}
        </div>
        <div class="flex justify-center"><span class="text-6xl font-bold">Newsweek</span></div>
        <div></div>
    </div>
    <div class="flex justify-between px-10 py-4">
        <nav class="flex gap-x-6">
            <NavLink href="/">Home</NavLink>
            <NavLink href="/?category=us">U.S.</NavLink>
            <NavLink href="/?category=world">World</NavLink>
            <NavLink href="/admin">Administracija</NavLink>
        </nav>

        {#if $page.props.logged_in}
            <NavLink href="/logout">Log out</NavLink>
        {/if}
    </div>
</header>

<main class="bg-white p-8">
    <slot />
</main>

<footer class="p-4 text-neutral-400 border-t border-t-neutral-300">
    <div class="border-b-neutral-300 border-b w-full flex justify-between">
        <span>&copy;{new Date().getFullYear()} NEWSWEEK</span>
        <span>Mate Pušić</span>
    </div>
</footer>
