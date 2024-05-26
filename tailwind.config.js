

/** @type {import('tailwindcss').Config} */
export default {
    content: ["./resources/**/*.{html,js,svelte,ts}"],
    theme: {
        extend: {},
    },
    plugins: [require('@tailwindcss/typography')],
    darkMode: ["class"],
    content: ["./resources/**/*.{html,js,svelte,ts}"],
    safelist: ["dark"],
    theme: {
        fontFamily: {
            'serif': ['Noto Serif', 'ui-serif'],
        },
        container: {
            center: true,
            padding: "2rem",
            screens: {
                "2xl": "1400px",
            },
        },
        extend: {
            dropShadow: {
                glow: [
                    "0 0px 20px rgba(255,255, 255, 0.35)",
                    "0 0px 65px rgba(255, 255,255, 0.2)"
                ],
                soft_glow: [
                    "0 0px 10px rgba(255,255, 255, 0.1)",
                ],
            },
            colors: {
                bjelopic_pumpkin: "#fe8534",
                bjelopic_orange: "#b80c09",
                bjelopic_black: "#010014",
                bjelopic_white: "#f6f5f4",
                bjelopic_red: "#f56050",
                bjelopic_amber: "#FFC100",
                bjelopic_night: "#141217",
                border: "hsl(var(--border) / <alpha-value>)",
                input: "hsl(var(--input) / <alpha-value>)",
                ring: "hsl(var(--ring) / <alpha-value>)",
                background: "hsl(var(--background) / <alpha-value>)",
                foreground: "hsl(var(--foreground) / <alpha-value>)",
                primary: {
                    DEFAULT: "hsl(var(--primary) / <alpha-value>)",
                    foreground: "hsl(var(--primary-foreground) / <alpha-value>)",
                },
                secondary: {
                    DEFAULT: "hsl(var(--secondary) / <alpha-value>)",
                    foreground: "hsl(var(--secondary-foreground) / <alpha-value>)",
                },
                destructive: {
                    DEFAULT: "hsl(var(--destructive) / <alpha-value>)",
                    foreground: "hsl(var(--destructive-foreground) / <alpha-value>)",
                },
                muted: {
                    DEFAULT: "hsl(var(--muted) / <alpha-value>)",
                    foreground: "hsl(var(--muted-foreground) / <alpha-value>)",
                },
                accent: {
                    DEFAULT: "hsl(var(--accent) / <alpha-value>)",
                    foreground: "hsl(var(--accent-foreground) / <alpha-value>)",
                },
                popover: {
                    DEFAULT: "hsl(var(--popover) / <alpha-value>)",
                    foreground: "hsl(var(--popover-foreground) / <alpha-value>)",
                },
                card: {
                    DEFAULT: "hsl(var(--card) / <alpha-value>)",
                    foreground: "hsl(var(--card-foreground) / <alpha-value>)",
                },
            },
        },
    },
}

