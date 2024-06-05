<script>
    import NavLink from "./Shared/NavLink.svelte";
    import { Link, page } from "@inertiajs/svelte";
    import { ChevronRight } from "lucide-svelte";
    import { Toaster } from "$lib/Shared/Components/Sonner";
</script>

<svelte:head>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet"
    />
</svelte:head>

<div class="flex flex-col min-h-lvh">
    <header>
        <div class="bg-red-600 text-white px-10 py-2 w-full">
            <div
                class="flex flex-col-reverse md:flex-row items-center md:items-end justify-between w-full max-w-screen-xl mx-auto"
            >
                <div
                    class="flex flex-col-reverse text-neutral-200 basis-auto md:basis-1/3"
                >
                    {new Date().toLocaleDateString()}
                </div>
                <div class="flex justify-center basis-full md:basis-1/3">
                    <Link href="">
                        <span class="text-6xl font-bold font-serif"
                            >Newsweek</span
                        >
                    </Link>
                </div>
                <div class="md:basis-1/3"></div>
            </div>
        </div>
        <div
            class="flex justify-between px-10 py-4 max-w-screen-xl mx-auto box-content flex-wrap"
        >
            <nav
                class="flex gap-x-10 items-center flex-wrap justify-center lg:justify-start gap-y-4"
            >
                <NavLink href="/">Home</NavLink>
                <NavLink href="/?category={encodeURI('U.S.')}">U.S.</NavLink>
                <NavLink href="/?category={encodeURI('World')}">World</NavLink>
                <NavLink href="/admin" startsWith={true}>Administracija</NavLink
                >
                {#if $page.props.logged_in}
                    <div class="md:hidden">
                        <NavLink href="/logout">Log out</NavLink>
                    </div>
                {/if}
                {#if $page.props.logged_in}
                    <div class="flex gap-x-10 items-center justify-center md:justify-start basis-full md:basis-auto">
                        <ChevronRight
                            class="{$page.url.startsWith('/admin')
                                ? ''
                                : 'text-neutral-400'} "
                        />
                        <NavLink href="/admin/posts">Posts</NavLink>
                        <NavLink href="/admin/users">Users</NavLink>
                    </div>
                {/if}
            </nav>

            {#if $page.props.logged_in}
                <div class="hidden md:block">
                    <NavLink href="/logout">Log out</NavLink>
                </div>
            {/if}
        </div>
    </header>

    <main class="bg-white w-full h-max flex-grow">
        <div class="max-w-screen-xl mx-auto box-content px-8 py-4">
            <slot />
        </div>
    </main>

    <footer
        class="p-4 text-neutral-400 border-t border-t-neutral-300 pb-20 h-fit"
    >
        <div class="max-w-screen-xl mx-auto w-full">
            <div
                class="border-b-neutral-300 border-b pb-4 w-full flex justify-between"
            >
                <span>&copy;{new Date().getFullYear()} NEWSWEEK</span>
                <span>Mate Pušić</span>
            </div>
        </div>
    </footer>
</div>
