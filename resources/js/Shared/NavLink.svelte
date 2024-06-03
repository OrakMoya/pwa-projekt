<script>
    import { Link, page } from "@inertiajs/svelte";
    let hrefLink = "/";
    let methodName = "get";
    let startsWith = false;

    export { hrefLink as href, methodName as method, startsWith };
</script>

<Link
    href={hrefLink}
    class=" {(
        startsWith
            ? $page.url.startsWith(hrefLink)
            : $page.url.endsWith(hrefLink)
    )
        ? 'font-bold'
        : 'font-light hover:font-normal'}"
    method={methodName}><slot /></Link
>
