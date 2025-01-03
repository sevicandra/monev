<style>
    *,
    :before,
    :after {
        box-sizing: border-box;
        border-width: 0;
        border-style: solid;
        border-color: #e5e7eb
    }

    :before,
    :after {
        --tw-content: ""
    }

    html {
        line-height: 1.5;
        -webkit-text-size-adjust: 100%;
        -moz-tab-size: 4;
        -o-tab-size: 4;
        tab-size: 4;
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", Segoe UI Symbol, "Noto Color Emoji";
        font-feature-settings: normal;
        font-variation-settings: normal
    }

    body {
        margin: 0;
        line-height: inherit
    }

    hr {
        height: 0;
        color: inherit;
        border-top-width: 1px
    }

    abbr:where([title]) {
        -webkit-text-decoration: underline dotted;
        text-decoration: underline dotted
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-size: inherit;
        font-weight: inherit
    }

    a {
        color: inherit;
        text-decoration: inherit
    }

    b,
    strong {
        font-weight: bolder
    }

    code,
    kbd,
    samp,
    pre {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, Liberation Mono, Courier New, monospace;
        font-size: 1em
    }

    small {
        font-size: 80%
    }

    sub,
    sup {
        font-size: 75%;
        line-height: 0;
        position: relative;
        vertical-align: baseline
    }

    sub {
        bottom: -.25em
    }

    sup {
        top: -.5em
    }

    table {
        text-indent: 0;
        border-color: inherit;
        border-collapse: collapse
    }

    button,
    input,
    optgroup,
    select,
    textarea {
        font-family: inherit;
        font-feature-settings: inherit;
        font-variation-settings: inherit;
        font-size: 100%;
        font-weight: inherit;
        line-height: inherit;
        color: inherit;
        margin: 0;
        padding: 0
    }

    button,
    select {
        text-transform: none
    }

    button,
    [type=button],
    [type=reset],
    [type=submit] {
        -webkit-appearance: button;
        background-color: transparent;
        background-image: none
    }

    :-moz-focusring {
        outline: auto
    }

    :-moz-ui-invalid {
        box-shadow: none
    }

    progress {
        vertical-align: baseline
    }

    ::-webkit-inner-spin-button,
    ::-webkit-outer-spin-button {
        height: auto
    }

    [type=search] {
        -webkit-appearance: textfield;
        outline-offset: -2px
    }

    ::-webkit-search-decoration {
        -webkit-appearance: none
    }

    ::-webkit-file-upload-button {
        -webkit-appearance: button;
        font: inherit
    }

    summary {
        display: list-item
    }

    blockquote,
    dl,
    dd,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    hr,
    figure,
    p,
    pre {
        margin: 0
    }

    fieldset {
        margin: 0;
        padding: 0
    }

    legend {
        padding: 0
    }

    ol,
    ul,
    menu {
        list-style: none;
        margin: 0;
        padding: 0
    }

    dialog {
        padding: 0
    }

    textarea {
        resize: vertical
    }

    input::-moz-placeholder,
    textarea::-moz-placeholder {
        opacity: 1;
        color: #9ca3af
    }

    input::placeholder,
    textarea::placeholder {
        opacity: 1;
        color: #9ca3af
    }

    button,
    [role=button] {
        cursor: pointer
    }

    :disabled {
        cursor: default
    }

    img,
    svg,
    video,
    canvas,
    audio,
    iframe,
    embed,
    object {
        display: block;
        vertical-align: middle
    }

    img,
    video {
        max-width: 100%;
        height: auto
    }

    [hidden] {
        display: none
    }

    :root,
    [data-theme] {
        background-color: var(--fallback-b1, oklch(var(--b1)/1));
        color: var(--fallback-bc, oklch(var(--bc)/1))
    }

    @supports not (color: oklch(0% 0 0)) {
        :root {
            color-scheme: light;
            --fallback-p: #491eff;
            --fallback-pc: #d4dbff;
            --fallback-s: #ff41c7;
            --fallback-sc: #fff9fc;
            --fallback-a: #00cfbd;
            --fallback-ac: #00100d;
            --fallback-n: #2b3440;
            --fallback-nc: #d7dde4;
            --fallback-b1: #ffffff;
            --fallback-b2: #e5e6e6;
            --fallback-b3: #e5e6e6;
            --fallback-bc: #1f2937;
            --fallback-in: #00b3f0;
            --fallback-inc: #000000;
            --fallback-su: #00ca92;
            --fallback-suc: #000000;
            --fallback-wa: #ffc22d;
            --fallback-wac: #000000;
            --fallback-er: #ff6f70;
            --fallback-erc: #000000
        }

        @media (prefers-color-scheme: dark) {
            :root {
                color-scheme: dark;
                --fallback-p: #7582ff;
                --fallback-pc: #050617;
                --fallback-s: #ff71cf;
                --fallback-sc: #190211;
                --fallback-a: #00c7b5;
                --fallback-ac: #000e0c;
                --fallback-n: #2a323c;
                --fallback-nc: #a6adbb;
                --fallback-b1: #1d232a;
                --fallback-b2: #191e24;
                --fallback-b3: #15191e;
                --fallback-bc: #a6adbb;
                --fallback-in: #00b3f0;
                --fallback-inc: #000000;
                --fallback-su: #00ca92;
                --fallback-suc: #000000;
                --fallback-wa: #ffc22d;
                --fallback-wac: #000000;
                --fallback-er: #ff6f70;
                --fallback-erc: #000000
            }
        }
    }

    html {
        -webkit-tap-highlight-color: transparent
    }

    * {
        scrollbar-color: color-mix(in oklch, currentColor 35%, transparent) transparent
    }

    *:hover {
        scrollbar-color: color-mix(in oklch, currentColor 60%, transparent) transparent
    }

    :root {
        color-scheme: light;
        --in: 72.06% .191 231.6;
        --su: 64.8% .15 160;
        --wa: 84.71% .199 83.87;
        --er: 71.76% .221 22.18;
        --pc: 89.824% .06192 275.75;
        --ac: 15.352% .0368 183.61;
        --inc: 0% 0 0;
        --suc: 0% 0 0;
        --wac: 0% 0 0;
        --erc: 0% 0 0;
        --rounded-box: 1rem;
        --rounded-btn: .5rem;
        --rounded-badge: 1.9rem;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --tab-radius: .5rem;
        --p: 49.12% .3096 275.75;
        --s: 69.71% .329 342.55;
        --sc: 98.71% .0106 342.55;
        --a: 76.76% .184 183.61;
        --n: 32.1785% .02476 255.701624;
        --nc: 89.4994% .011585 252.096176;
        --b1: 100% 0 0;
        --b2: 96.1151% 0 0;
        --b3: 92.4169% .00108 197.137559;
        --bc: 27.8078% .029596 256.847952
    }

    @media (prefers-color-scheme: dark) {
        :root {
            color-scheme: dark;
            --in: 72.06% .191 231.6;
            --su: 64.8% .15 160;
            --wa: 84.71% .199 83.87;
            --er: 71.76% .221 22.18;
            --pc: 13.138% .0392 275.75;
            --sc: 14.96% .052 342.55;
            --ac: 14.902% .0334 183.61;
            --inc: 0% 0 0;
            --suc: 0% 0 0;
            --wac: 0% 0 0;
            --erc: 0% 0 0;
            --rounded-box: 1rem;
            --rounded-btn: .5rem;
            --rounded-badge: 1.9rem;
            --animation-btn: .25s;
            --animation-input: .2s;
            --btn-focus-scale: .95;
            --border-btn: 1px;
            --tab-border: 1px;
            --tab-radius: .5rem;
            --p: 65.69% .196 275.75;
            --s: 74.8% .26 342.55;
            --a: 74.51% .167 183.61;
            --n: 31.3815% .021108 254.139175;
            --nc: 74.6477% .0216 264.435964;
            --b1: 25.3267% .015896 252.417568;
            --b2: 23.2607% .013807 253.100675;
            --b3: 21.1484% .01165 254.087939;
            --bc: 74.6477% .0216 264.435964
        }
    }

    [data-theme=light] {
        color-scheme: light;
        --in: 72.06% .191 231.6;
        --su: 64.8% .15 160;
        --wa: 84.71% .199 83.87;
        --er: 71.76% .221 22.18;
        --pc: 89.824% .06192 275.75;
        --ac: 15.352% .0368 183.61;
        --inc: 0% 0 0;
        --suc: 0% 0 0;
        --wac: 0% 0 0;
        --erc: 0% 0 0;
        --rounded-box: 1rem;
        --rounded-btn: .5rem;
        --rounded-badge: 1.9rem;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --tab-radius: .5rem;
        --p: 49.12% .3096 275.75;
        --s: 69.71% .329 342.55;
        --sc: 98.71% .0106 342.55;
        --a: 76.76% .184 183.61;
        --n: 32.1785% .02476 255.701624;
        --nc: 89.4994% .011585 252.096176;
        --b1: 100% 0 0;
        --b2: 96.1151% 0 0;
        --b3: 92.4169% .00108 197.137559;
        --bc: 27.8078% .029596 256.847952
    }

    [data-theme=dark] {
        color-scheme: dark;
        --in: 72.06% .191 231.6;
        --su: 64.8% .15 160;
        --wa: 84.71% .199 83.87;
        --er: 71.76% .221 22.18;
        --pc: 13.138% .0392 275.75;
        --sc: 14.96% .052 342.55;
        --ac: 14.902% .0334 183.61;
        --inc: 0% 0 0;
        --suc: 0% 0 0;
        --wac: 0% 0 0;
        --erc: 0% 0 0;
        --rounded-box: 1rem;
        --rounded-btn: .5rem;
        --rounded-badge: 1.9rem;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --tab-radius: .5rem;
        --p: 65.69% .196 275.75;
        --s: 74.8% .26 342.55;
        --a: 74.51% .167 183.61;
        --n: 31.3815% .021108 254.139175;
        --nc: 74.6477% .0216 264.435964;
        --b1: 25.3267% .015896 252.417568;
        --b2: 23.2607% .013807 253.100675;
        --b3: 21.1484% .01165 254.087939;
        --bc: 74.6477% .0216 264.435964
    }

    [data-theme=cupcake] {
        color-scheme: light;
        --in: 72.06% .191 231.6;
        --su: 64.8% .15 160;
        --wa: 84.71% .199 83.87;
        --er: 71.76% .221 22.18;
        --pc: 15.2344% .017892 200.026556;
        --sc: 15.787% .020249 356.29965;
        --ac: 15.8762% .029206 78.618794;
        --nc: 84.7148% .013247 313.189598;
        --inc: 0% 0 0;
        --suc: 0% 0 0;
        --wac: 0% 0 0;
        --erc: 0% 0 0;
        --rounded-box: 1rem;
        --rounded-badge: 1.9rem;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --p: 76.172% .089459 200.026556;
        --s: 78.9351% .101246 356.29965;
        --a: 79.3811% .146032 78.618794;
        --n: 23.5742% .066235 313.189598;
        --b1: 97.7882% .00418 56.375637;
        --b2: 93.9822% .007638 61.449292;
        --b3: 91.5861% .006811 53.440502;
        --bc: 23.5742% .066235 313.189598;
        --rounded-btn: 1.9rem;
        --tab-border: 2px;
        --tab-radius: .7rem
    }

    [data-theme=bumblebee] {
        color-scheme: light;
        --b2: 93% 0 0;
        --b3: 86% 0 0;
        --in: 72.06% .191 231.6;
        --su: 64.8% .15 160;
        --wa: 84.71% .199 83.87;
        --er: 71.76% .221 22.18;
        --bc: 20% 0 0;
        --ac: 16.254% .0314 56.52;
        --nc: 82.55% .015 281.99;
        --inc: 0% 0 0;
        --suc: 0% 0 0;
        --wac: 0% 0 0;
        --erc: 0% 0 0;
        --rounded-box: 1rem;
        --rounded-btn: .5rem;
        --rounded-badge: 1.9rem;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --tab-radius: .5rem;
        --p: 89.51% .2132 96.61;
        --pc: 38.92% .046 96.61;
        --s: 80.39% .194 70.76;
        --sc: 39.38% .068 70.76;
        --a: 81.27% .157 56.52;
        --n: 12.75% .075 281.99;
        --b1: 100% 0 0
    }

    [data-theme=emerald] {
        color-scheme: light;
        --b2: 93% 0 0;
        --b3: 86% 0 0;
        --in: 72.06% .191 231.6;
        --su: 64.8% .15 160;
        --wa: 84.71% .199 83.87;
        --er: 71.76% .221 22.18;
        --inc: 0% 0 0;
        --suc: 0% 0 0;
        --wac: 0% 0 0;
        --erc: 0% 0 0;
        --rounded-box: 1rem;
        --rounded-btn: .5rem;
        --rounded-badge: 1.9rem;
        --border-btn: 1px;
        --tab-border: 1px;
        --tab-radius: .5rem;
        --p: 76.6626% .135433 153.450024;
        --pc: 33.3872% .040618 162.240129;
        --s: 61.3028% .202368 261.294233;
        --sc: 100% 0 0;
        --a: 72.7725% .149783 33.200363;
        --ac: 0% 0 0;
        --n: 35.5192% .032071 262.988584;
        --nc: 98.4625% .001706 247.838921;
        --b1: 100% 0 0;
        --bc: 35.5192% .032071 262.988584;
        --animation-btn: 0;
        --animation-input: 0;
        --btn-focus-scale: 1
    }

    [data-theme=corporate] {
        color-scheme: light;
        --b2: 93% 0 0;
        --b3: 86% 0 0;
        --in: 72.06% .191 231.6;
        --su: 64.8% .15 160;
        --wa: 84.71% .199 83.87;
        --er: 71.76% .221 22.18;
        --pc: 12.078% .0456 269.1;
        --sc: 13.0739% .010951 256.688055;
        --ac: 15.3934% .022799 163.57888;
        --inc: 0% 0 0;
        --suc: 0% 0 0;
        --wac: 0% 0 0;
        --erc: 0% 0 0;
        --border-btn: 1px;
        --tab-border: 1px;
        --p: 60.39% .228 269.1;
        --s: 65.3694% .054756 256.688055;
        --a: 76.9669% .113994 163.57888;
        --n: 22.3899% .031305 278.07229;
        --nc: 95.8796% .008588 247.915135;
        --b1: 100% 0 0;
        --bc: 22.3899% .031305 278.07229;
        --rounded-box: .25rem;
        --rounded-btn: .125rem;
        --rounded-badge: .125rem;
        --tab-radius: .25rem;
        --animation-btn: 0;
        --animation-input: 0;
        --btn-focus-scale: 1
    }

    [data-theme=synthwave] {
        color-scheme: dark;
        --b2: 20.2941% .076211 287.835609;
        --b3: 18.7665% .070475 287.835609;
        --pc: 14.4421% .031903 342.009383;
        --sc: 15.6543% .02362 227.382405;
        --ac: 17.608% .0412 93.72;
        --rounded-box: 1rem;
        --rounded-btn: .5rem;
        --rounded-badge: 1.9rem;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --tab-radius: .5rem;
        --p: 72.2105% .159514 342.009383;
        --s: 78.2714% .118101 227.382405;
        --a: 88.04% .206 93.72;
        --n: 25.5554% .103537 286.507967;
        --nc: 97.9365% .00819 301.358346;
        --b1: 21.8216% .081948 287.835609;
        --bc: 97.9365% .00819 301.358346;
        --in: 76.5197% .12273 231.831603;
        --inc: 23.5017% .096418 290.329844;
        --su: 86.0572% .115038 178.624677;
        --suc: 23.5017% .096418 290.329844;
        --wa: 85.531% .122117 93.722227;
        --wac: 23.5017% .096418 290.329844;
        --er: 73.7005% .121339 32.639257;
        --erc: 23.5017% .096418 290.329844
    }

    [data-theme=retro] {
        color-scheme: light;
        --inc: 90.923% .043042 262.880917;
        --suc: 12.541% .033982 149.213788;
        --wac: 13.3168% .031484 58.31834;
        --erc: 13.144% .0398 27.33;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --p: 76.8664% .104092 22.664655;
        --pc: 26.5104% .006243 .522862;
        --s: 80.7415% .052534 159.094608;
        --sc: 26.5104% .006243 .522862;
        --a: 70.3919% .125455 52.953428;
        --ac: 26.5104% .006243 .522862;
        --n: 28.4181% .009519 355.534017;
        --nc: 92.5604% .025113 89.217311;
        --b1: 91.6374% .034554 90.51575;
        --b2: 88.2722% .049418 91.774344;
        --b3: 84.133% .065952 90.856665;
        --bc: 26.5104% .006243 .522862;
        --in: 54.615% .215208 262.880917;
        --su: 62.7052% .169912 149.213788;
        --wa: 66.584% .157422 58.31834;
        --er: 65.72% .199 27.33;
        --rounded-box: .4rem;
        --rounded-btn: .4rem;
        --rounded-badge: .4rem;
        --tab-radius: .4rem
    }

    [data-theme=cyberpunk] {
        color-scheme: light;
        --b2: 87.8943% .16647 104.32;
        --b3: 81.2786% .15394 104.32;
        --in: 72.06% .191 231.6;
        --su: 64.8% .15 160;
        --wa: 84.71% .199 83.87;
        --er: 71.76% .221 22.18;
        --bc: 18.902% .0358 104.32;
        --pc: 14.844% .0418 6.35;
        --sc: 16.666% .0368 204.72;
        --ac: 14.372% .04352 310.43;
        --inc: 0% 0 0;
        --suc: 0% 0 0;
        --wac: 0% 0 0;
        --erc: 0% 0 0;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, Liberation Mono, Courier New, monospace;
        --p: 74.22% .209 6.35;
        --s: 83.33% .184 204.72;
        --a: 71.86% .2176 310.43;
        --n: 23.04% .065 269.31;
        --nc: 94.51% .179 104.32;
        --b1: 94.51% .179 104.32;
        --rounded-box: 0;
        --rounded-btn: 0;
        --rounded-badge: 0;
        --tab-radius: 0
    }

    [data-theme=valentine] {
        color-scheme: light;
        --b2: 88.0567% .024834 337.06289;
        --b3: 81.4288% .022964 337.06289;
        --pc: 13.7239% .030755 15.066527;
        --sc: 14.3942% .029258 293.189609;
        --ac: 14.2537% .014961 197.828857;
        --inc: 90.923% .043042 262.880917;
        --suc: 12.541% .033982 149.213788;
        --wac: 13.3168% .031484 58.31834;
        --erc: 14.614% .0414 27.33;
        --rounded-box: 1rem;
        --rounded-badge: 1.9rem;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --p: 68.6197% .153774 15.066527;
        --s: 71.971% .14629 293.189609;
        --a: 71.2685% .074804 197.828857;
        --n: 54.6053% .143342 358.004839;
        --nc: 90.2701% .037202 336.955191;
        --b1: 94.6846% .026703 337.06289;
        --bc: 37.3085% .081131 4.606426;
        --in: 54.615% .215208 262.880917;
        --su: 62.7052% .169912 149.213788;
        --wa: 66.584% .157422 58.31834;
        --er: 73.07% .207 27.33;
        --rounded-btn: 1.9rem;
        --tab-radius: .7rem
    }

    [data-theme=halloween] {
        color-scheme: dark;
        --b2: 23.0416% 0 0;
        --b3: 21.3072% 0 0;
        --bc: 84.9552% 0 0;
        --sc: 89.196% .0496 305.03;
        --nc: 84.8742% .009322 65.681484;
        --inc: 90.923% .043042 262.880917;
        --suc: 12.541% .033982 149.213788;
        --wac: 13.3168% .031484 58.31834;
        --erc: 13.144% .0398 27.33;
        --rounded-box: 1rem;
        --rounded-btn: .5rem;
        --rounded-badge: 1.9rem;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --tab-radius: .5rem;
        --p: 77.48% .204 60.62;
        --pc: 19.6935% .004671 196.779412;
        --s: 45.98% .248 305.03;
        --a: 64.8% .223 136.073479;
        --ac: 0% 0 0;
        --n: 24.371% .046608 65.681484;
        --b1: 24.7759% 0 0;
        --in: 54.615% .215208 262.880917;
        --su: 62.7052% .169912 149.213788;
        --wa: 66.584% .157422 58.31834;
        --er: 65.72% .199 27.33
    }

    [data-theme=garden] {
        color-scheme: light;
        --b2: 86.4453% .002011 17.197414;
        --b3: 79.9386% .00186 17.197414;
        --in: 72.06% .191 231.6;
        --su: 64.8% .15 160;
        --wa: 84.71% .199 83.87;
        --er: 71.76% .221 22.18;
        --sc: 89.699% .022197 355.095988;
        --ac: 11.2547% .010859 154.390187;
        --inc: 0% 0 0;
        --suc: 0% 0 0;
        --wac: 0% 0 0;
        --erc: 0% 0 0;
        --rounded-box: 1rem;
        --rounded-btn: .5rem;
        --rounded-badge: 1.9rem;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --tab-radius: .5rem;
        --p: 62.45% .278 3.83636;
        --pc: 100% 0 0;
        --s: 48.4952% .110985 355.095988;
        --a: 56.2735% .054297 154.390187;
        --n: 24.1559% .049362 89.070594;
        --nc: 92.9519% .002163 17.197414;
        --b1: 92.9519% .002163 17.197414;
        --bc: 16.9617% .001664 17.32068
    }

    [data-theme=forest] {
        color-scheme: dark;
        --b2: 17.522% .007709 17.911578;
        --b3: 16.2032% .007129 17.911578;
        --in: 72.06% .191 231.6;
        --su: 64.8% .15 160;
        --wa: 84.71% .199 83.87;
        --er: 71.76% .221 22.18;
        --bc: 83.7682% .001658 17.911578;
        --sc: 13.9553% .027077 168.327128;
        --ac: 14.1257% .02389 185.713193;
        --nc: 86.1397% .007806 171.364646;
        --inc: 0% 0 0;
        --suc: 0% 0 0;
        --wac: 0% 0 0;
        --erc: 0% 0 0;
        --rounded-box: 1rem;
        --rounded-badge: 1.9rem;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --tab-radius: .5rem;
        --p: 68.6283% .185567 148.958922;
        --pc: 0% 0 0;
        --s: 69.7764% .135385 168.327128;
        --a: 70.6285% .119451 185.713193;
        --n: 30.6985% .039032 171.364646;
        --b1: 18.8409% .00829 17.911578;
        --rounded-btn: 1.9rem
    }

    [data-theme=aqua] {
        color-scheme: dark;
        --b2: 45.3464% .118611 261.181672;
        --b3: 41.9333% .109683 261.181672;
        --bc: 89.7519% .025508 261.181672;
        --sc: 12.1365% .02175 309.782946;
        --ac: 18.6854% .020445 94.555431;
        --nc: 12.2124% .023402 243.760661;
        --inc: 90.923% .043042 262.880917;
        --suc: 12.541% .033982 149.213788;
        --wac: 13.3168% .031484 58.31834;
        --erc: 14.79% .038 27.33;
        --rounded-box: 1rem;
        --rounded-btn: .5rem;
        --rounded-badge: 1.9rem;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --tab-radius: .5rem;
        --p: 85.6617% .14498 198.6458;
        --pc: 40.1249% .068266 197.603872;
        --s: 60.6827% .108752 309.782946;
        --a: 93.4269% .102225 94.555431;
        --n: 61.0622% .117009 243.760661;
        --b1: 48.7596% .127539 261.181672;
        --in: 54.615% .215208 262.880917;
        --su: 62.7052% .169912 149.213788;
        --wa: 66.584% .157422 58.31834;
        --er: 73.95% .19 27.33
    }

    [data-theme=lofi] {
        color-scheme: light;
        --inc: 15.908% .0206 205.9;
        --suc: 18.026% .0306 164.14;
        --wac: 17.674% .027 79.94;
        --erc: 15.732% .03 28.47;
        --border-btn: 1px;
        --tab-border: 1px;
        --p: 15.9066% 0 0;
        --pc: 100% 0 0;
        --s: 21.455% .001566 17.278957;
        --sc: 100% 0 0;
        --a: 26.8618% 0 0;
        --ac: 100% 0 0;
        --n: 0% 0 0;
        --nc: 100% 0 0;
        --b1: 100% 0 0;
        --b2: 96.1151% 0 0;
        --b3: 92.268% .001082 17.17934;
        --bc: 0% 0 0;
        --in: 79.54% .103 205.9;
        --su: 90.13% .153 164.14;
        --wa: 88.37% .135 79.94;
        --er: 78.66% .15 28.47;
        --rounded-box: .25rem;
        --rounded-btn: .125rem;
        --rounded-badge: .125rem;
        --tab-radius: .125rem;
        --animation-btn: 0;
        --animation-input: 0;
        --btn-focus-scale: 1
    }

    [data-theme=pastel] {
        color-scheme: light;
        --in: 72.06% .191 231.6;
        --su: 64.8% .15 160;
        --wa: 84.71% .199 83.87;
        --er: 71.76% .221 22.18;
        --bc: 20% 0 0;
        --pc: 16.6166% .006979 316.8737;
        --sc: 17.6153% .009839 8.688364;
        --ac: 17.8419% .012056 170.923263;
        --nc: 14.2681% .014702 228.183906;
        --inc: 0% 0 0;
        --suc: 0% 0 0;
        --wac: 0% 0 0;
        --erc: 0% 0 0;
        --rounded-box: 1rem;
        --rounded-badge: 1.9rem;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --p: 83.0828% .034896 316.8737;
        --s: 88.0763% .049197 8.688364;
        --a: 89.2096% .06028 170.923263;
        --n: 71.3406% .07351 228.183906;
        --b1: 100% 0 0;
        --b2: 98.4625% .001706 247.838921;
        --b3: 87.1681% .009339 258.338227;
        --rounded-btn: 1.9rem;
        --tab-radius: .7rem
    }

    [data-theme=fantasy] {
        color-scheme: light;
        --b2: 93% 0 0;
        --b3: 86% 0 0;
        --in: 72.06% .191 231.6;
        --su: 64.8% .15 160;
        --wa: 84.71% .199 83.87;
        --er: 71.76% .221 22.18;
        --pc: 87.49% .0378 325.02;
        --sc: 90.784% .0324 241.36;
        --ac: 15.196% .0408 56.72;
        --nc: 85.5616% .005919 256.847952;
        --inc: 0% 0 0;
        --suc: 0% 0 0;
        --wac: 0% 0 0;
        --erc: 0% 0 0;
        --rounded-box: 1rem;
        --rounded-btn: .5rem;
        --rounded-badge: 1.9rem;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --tab-radius: .5rem;
        --p: 37.45% .189 325.02;
        --s: 53.92% .162 241.36;
        --a: 75.98% .204 56.72;
        --n: 27.8078% .029596 256.847952;
        --b1: 100% 0 0;
        --bc: 27.8078% .029596 256.847952
    }

    [data-theme=wireframe] {
        color-scheme: light;
        --bc: 20% 0 0;
        --pc: 15.6521% 0 0;
        --sc: 15.6521% 0 0;
        --ac: 15.6521% 0 0;
        --nc: 18.8014% 0 0;
        --inc: 89.0403% .062643 264.052021;
        --suc: 90.395% .035372 142.495339;
        --wac: 14.1626% .019994 108.702381;
        --erc: 12.5591% .051537 29.233885;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        font-family: Chalkboard, comic sans ms, "sans-serif";
        --p: 78.2604% 0 0;
        --s: 78.2604% 0 0;
        --a: 78.2604% 0 0;
        --n: 94.007% 0 0;
        --b1: 100% 0 0;
        --b2: 94.9119% 0 0;
        --b3: 89.7547% 0 0;
        --in: 45.2014% .313214 264.052021;
        --su: 51.9752% .176858 142.495339;
        --wa: 70.8131% .099969 108.702381;
        --er: 62.7955% .257683 29.233885;
        --rounded-box: .2rem;
        --rounded-btn: .2rem;
        --rounded-badge: .2rem;
        --tab-radius: .2rem
    }

    [data-theme=black] {
        color-scheme: dark;
        --pc: 86.736% 0 0;
        --sc: 86.736% 0 0;
        --ac: 86.736% 0 0;
        --nc: 86.736% 0 0;
        --inc: 89.0403% .062643 264.052021;
        --suc: 90.395% .035372 142.495339;
        --wac: 19.3597% .042201 109.769232;
        --erc: 12.5591% .051537 29.233885;
        --border-btn: 1px;
        --tab-border: 1px;
        --p: 33.6799% 0 0;
        --s: 33.6799% 0 0;
        --a: 33.6799% 0 0;
        --b1: 0% 0 0;
        --b2: 19.1251% 0 0;
        --b3: 26.8618% 0 0;
        --bc: 87.6096% 0 0;
        --n: 33.6799% 0 0;
        --in: 45.2014% .313214 264.052021;
        --su: 51.9752% .176858 142.495339;
        --wa: 96.7983% .211006 109.769232;
        --er: 62.7955% .257683 29.233885;
        --rounded-box: 0;
        --rounded-btn: 0;
        --rounded-badge: 0;
        --animation-btn: 0;
        --animation-input: 0;
        --btn-focus-scale: 1;
        --tab-radius: 0
    }

    [data-theme=luxury] {
        color-scheme: dark;
        --pc: 20% 0 0;
        --sc: 85.5163% .012821 261.069149;
        --ac: 87.3349% .010348 338.82597;
        --inc: 15.8122% .024356 237.133883;
        --suc: 15.6239% .038579 132.154381;
        --wac: 17.2255% .027305 102.89115;
        --erc: 14.3506% .035271 22.568916;
        --rounded-box: 1rem;
        --rounded-btn: .5rem;
        --rounded-badge: 1.9rem;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --tab-radius: .5rem;
        --p: 100% 0 0;
        --s: 27.5815% .064106 261.069149;
        --a: 36.6744% .051741 338.82597;
        --n: 24.27% .057015 59.825019;
        --nc: 93.2033% .089631 90.861683;
        --b1: 14.0765% .004386 285.822869;
        --b2: 20.2191% .004211 308.22937;
        --b3: 29.8961% .003818 308.318612;
        --bc: 75.6879% .123666 76.890484;
        --in: 79.0612% .121778 237.133883;
        --su: 78.1197% .192894 132.154381;
        --wa: 86.1274% .136524 102.89115;
        --er: 71.7531% .176357 22.568916
    }

    [data-theme=dracula] {
        color-scheme: dark;
        --b2: 26.8053% .020556 277.508664;
        --b3: 24.7877% .019009 277.508664;
        --pc: 15.0922% .036614 346.812432;
        --sc: 14.8405% .029709 301.883095;
        --ac: 16.6785% .024826 66.558491;
        --nc: 87.8891% .006515 275.524078;
        --inc: 17.6526% .018676 212.846491;
        --suc: 17.4199% .043903 148.024881;
        --wac: 19.1068% .026849 112.757109;
        --erc: 13.6441% .041266 24.430965;
        --rounded-box: 1rem;
        --rounded-btn: .5rem;
        --rounded-badge: 1.9rem;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --tab-radius: .5rem;
        --p: 75.4611% .18307 346.812432;
        --s: 74.2023% .148546 301.883095;
        --a: 83.3927% .124132 66.558491;
        --n: 39.4456% .032576 275.524078;
        --b1: 28.8229% .022103 277.508664;
        --bc: 97.7477% .007913 106.545019;
        --in: 88.263% .09338 212.846491;
        --su: 87.0995% .219516 148.024881;
        --wa: 95.5338% .134246 112.757109;
        --er: 68.2204% .206328 24.430965
    }

    [data-theme=cmyk] {
        color-scheme: light;
        --b2: 93% 0 0;
        --b3: 86% 0 0;
        --bc: 20% 0 0;
        --pc: 14.3544% .02666 239.443325;
        --sc: 12.8953% .040552 359.339283;
        --ac: 18.8458% .037948 105.306968;
        --nc: 84.3557% 0 0;
        --inc: 13.6952% .0189 217.284104;
        --suc: 89.3898% .032505 321.406278;
        --wac: 14.2473% .031969 52.023412;
        --erc: 12.4027% .041677 28.717543;
        --rounded-box: 1rem;
        --rounded-btn: .5rem;
        --rounded-badge: 1.9rem;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --tab-radius: .5rem;
        --p: 71.7722% .133298 239.443325;
        --s: 64.4766% .202758 359.339283;
        --a: 94.2289% .189741 105.306968;
        --n: 21.7787% 0 0;
        --b1: 100% 0 0;
        --in: 68.4759% .094499 217.284104;
        --su: 46.949% .162524 321.406278;
        --wa: 71.2364% .159843 52.023412;
        --er: 62.0133% .208385 28.717543
    }

    [data-theme=autumn] {
        color-scheme: light;
        --b2: 89.1077% 0 0;
        --b3: 82.4006% 0 0;
        --bc: 19.1629% 0 0;
        --pc: 88.1446% .032232 17.530175;
        --sc: 12.3353% .033821 23.865865;
        --ac: 14.6851% .018999 60.729616;
        --nc: 90.8734% .007475 51.902819;
        --inc: 13.8449% .019596 207.284192;
        --suc: 12.199% .016032 174.616213;
        --wac: 14.0163% .032982 56.844303;
        --erc: 90.614% .0482 24.16;
        --rounded-box: 1rem;
        --rounded-btn: .5rem;
        --rounded-badge: 1.9rem;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --tab-radius: .5rem;
        --p: 40.7232% .16116 17.530175;
        --s: 61.6763% .169105 23.865865;
        --a: 73.4253% .094994 60.729616;
        --n: 54.3672% .037374 51.902819;
        --b1: 95.8147% 0 0;
        --in: 69.2245% .097979 207.284192;
        --su: 60.9951% .080159 174.616213;
        --wa: 70.0817% .164909 56.844303;
        --er: 53.07% .241 24.16
    }

    [data-theme=business] {
        color-scheme: dark;
        --b2: 22.6487% 0 0;
        --b3: 20.944% 0 0;
        --bc: 84.8707% 0 0;
        --pc: 88.3407% .019811 251.473931;
        --sc: 12.8185% .005481 229.389418;
        --ac: 13.4542% .033545 35.791525;
        --nc: 85.4882% .00265 253.041249;
        --inc: 12.5233% .028702 240.033697;
        --suc: 14.0454% .018919 156.59611;
        --wac: 15.4965% .023141 81.519177;
        --erc: 90.3221% .029356 29.674507;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --tab-radius: .5rem;
        --p: 41.7036% .099057 251.473931;
        --s: 64.0924% .027405 229.389418;
        --a: 67.271% .167726 35.791525;
        --n: 27.441% .01325 253.041249;
        --b1: 24.3535% 0 0;
        --in: 62.6163% .143511 240.033697;
        --su: 70.2268% .094594 156.59611;
        --wa: 77.4824% .115704 81.519177;
        --er: 51.6105% .14678 29.674507;
        --rounded-box: .25rem;
        --rounded-btn: .125rem;
        --rounded-badge: .125rem
    }

    [data-theme=acid] {
        color-scheme: light;
        --b2: 91.6146% 0 0;
        --b3: 84.7189% 0 0;
        --bc: 19.7021% 0 0;
        --pc: 14.38% .0714 330.759573;
        --sc: 14.674% .0448 48.250878;
        --ac: 18.556% .0528 122.962951;
        --nc: 84.262% .0256 278.68;
        --inc: 12.144% .0454 252.05;
        --suc: 17.144% .0532 158.53;
        --wac: 18.202% .0424 100.5;
        --erc: 12.968% .0586 29.349188;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --p: 71.9% .357 330.759573;
        --s: 73.37% .224 48.250878;
        --a: 92.78% .264 122.962951;
        --n: 21.31% .128 278.68;
        --b1: 98.5104% 0 0;
        --in: 60.72% .227 252.05;
        --su: 85.72% .266 158.53;
        --wa: 91.01% .212 100.5;
        --er: 64.84% .293 29.349188;
        --rounded-box: 1.25rem;
        --rounded-btn: 1rem;
        --rounded-badge: 1rem;
        --tab-radius: .7rem
    }

    [data-theme=lemonade] {
        color-scheme: light;
        --b2: 91.8003% .0186 123.72;
        --b3: 84.8906% .0172 123.72;
        --bc: 19.742% .004 123.72;
        --pc: 11.784% .0398 134.6;
        --sc: 15.55% .0392 111.09;
        --ac: 17.078% .0402 100.73;
        --nc: 86.196% .015 108.6;
        --inc: 17.238% .0094 224.14;
        --suc: 17.238% .0094 157.85;
        --wac: 17.238% .0094 102.15;
        --erc: 17.238% .0094 25.85;
        --rounded-box: 1rem;
        --rounded-btn: .5rem;
        --rounded-badge: 1.9rem;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --tab-radius: .5rem;
        --p: 58.92% .199 134.6;
        --s: 77.75% .196 111.09;
        --a: 85.39% .201 100.73;
        --n: 30.98% .075 108.6;
        --b1: 98.71% .02 123.72;
        --in: 86.19% .047 224.14;
        --su: 86.19% .047 157.85;
        --wa: 86.19% .047 102.15;
        --er: 86.19% .047 25.85
    }

    [data-theme=night] {
        color-scheme: dark;
        --b2: 19.3144% .037037 265.754874;
        --b3: 17.8606% .034249 265.754874;
        --bc: 84.1536% .007965 265.754874;
        --pc: 15.0703% .027798 232.66148;
        --sc: 13.6023% .031661 276.934902;
        --ac: 14.4721% .035244 350.048739;
        --nc: 85.5899% .00737 260.030984;
        --suc: 15.6904% .026506 181.911977;
        --wac: 16.6486% .027912 82.95003;
        --erc: 14.3572% .034051 13.11834;
        --rounded-box: 1rem;
        --rounded-btn: .5rem;
        --rounded-badge: 1.9rem;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --tab-radius: .5rem;
        --p: 75.3513% .138989 232.66148;
        --s: 68.0113% .158303 276.934902;
        --a: 72.3603% .176218 350.048739;
        --n: 27.9495% .036848 260.030984;
        --b1: 20.7682% .039824 265.754874;
        --in: 68.4553% .148062 237.25135;
        --inc: 0% 0 0;
        --su: 78.452% .132529 181.911977;
        --wa: 83.2428% .139558 82.95003;
        --er: 71.7858% .170255 13.11834
    }

    [data-theme=coffee] {
        color-scheme: dark;
        --b2: 20.1585% .021457 329.708637;
        --b3: 18.6412% .019842 329.708637;
        --pc: 14.3993% .024765 62.756393;
        --sc: 86.893% .00597 199.19444;
        --ac: 88.5243% .014881 224.389184;
        --nc: 83.3022% .003149 326.261446;
        --inc: 15.898% .012774 184.558367;
        --suc: 14.9445% .014491 131.116276;
        --wac: 17.6301% .028162 87.722413;
        --erc: 15.4637% .025644 31.871922;
        --rounded-box: 1rem;
        --rounded-btn: .5rem;
        --rounded-badge: 1.9rem;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --tab-radius: .5rem;
        --p: 71.9967% .123825 62.756393;
        --s: 34.465% .029849 199.19444;
        --a: 42.6213% .074405 224.389184;
        --n: 16.5109% .015743 326.261446;
        --b1: 21.6758% .023072 329.708637;
        --bc: 72.3547% .092794 79.129387;
        --in: 79.4902% .063869 184.558367;
        --su: 74.7224% .072456 131.116276;
        --wa: 88.1503% .140812 87.722413;
        --er: 77.3187% .12822 31.871922
    }

    [data-theme=winter] {
        color-scheme: light;
        --pc: 91.372% .051 257.57;
        --sc: 88.5103% .03222 282.339433;
        --ac: 11.988% .038303 335.171434;
        --nc: 83.9233% .012704 257.651965;
        --inc: 17.6255% .017178 214.515264;
        --suc: 16.0988% .015404 197.823719;
        --wac: 17.8345% .009167 71.47031;
        --erc: 14.6185% .022037 20.076293;
        --rounded-box: 1rem;
        --rounded-btn: .5rem;
        --rounded-badge: 1.9rem;
        --animation-btn: .25s;
        --animation-input: .2s;
        --btn-focus-scale: .95;
        --border-btn: 1px;
        --tab-border: 1px;
        --tab-radius: .5rem;
        --p: 56.86% .255 257.57;
        --s: 42.5516% .161098 282.339433;
        --a: 59.9398% .191515 335.171434;
        --n: 19.6166% .063518 257.651965;
        --b1: 100% 0 0;
        --b2: 97.4663% .011947 259.822565;
        --b3: 93.2686% .016223 262.751375;
        --bc: 41.8869% .053885 255.824911;
        --in: 88.1275% .085888 214.515264;
        --su: 80.4941% .077019 197.823719;
        --wa: 89.1725% .045833 71.47031;
        --er: 73.0926% .110185 20.076293
    }

    *,
    :before,
    :after {
        --tw-border-spacing-x: 0;
        --tw-border-spacing-y: 0;
        --tw-translate-x: 0;
        --tw-translate-y: 0;
        --tw-rotate: 0;
        --tw-skew-x: 0;
        --tw-skew-y: 0;
        --tw-scale-x: 1;
        --tw-scale-y: 1;
        --tw-pan-x: ;
        --tw-pan-y: ;
        --tw-pinch-zoom: ;
        --tw-scroll-snap-strictness: proximity;
        --tw-gradient-from-position: ;
        --tw-gradient-via-position: ;
        --tw-gradient-to-position: ;
        --tw-ordinal: ;
        --tw-slashed-zero: ;
        --tw-numeric-figure: ;
        --tw-numeric-spacing: ;
        --tw-numeric-fraction: ;
        --tw-ring-inset: ;
        --tw-ring-offset-width: 0px;
        --tw-ring-offset-color: #fff;
        --tw-ring-color: rgb(59 130 246 / .5);
        --tw-ring-offset-shadow: 0 0 #0000;
        --tw-ring-shadow: 0 0 #0000;
        --tw-shadow: 0 0 #0000;
        --tw-shadow-colored: 0 0 #0000;
        --tw-blur: ;
        --tw-brightness: ;
        --tw-contrast: ;
        --tw-grayscale: ;
        --tw-hue-rotate: ;
        --tw-invert: ;
        --tw-saturate: ;
        --tw-sepia: ;
        --tw-drop-shadow: ;
        --tw-backdrop-blur: ;
        --tw-backdrop-brightness: ;
        --tw-backdrop-contrast: ;
        --tw-backdrop-grayscale: ;
        --tw-backdrop-hue-rotate: ;
        --tw-backdrop-invert: ;
        --tw-backdrop-opacity: ;
        --tw-backdrop-saturate: ;
        --tw-backdrop-sepia:
    }

    ::backdrop {
        --tw-border-spacing-x: 0;
        --tw-border-spacing-y: 0;
        --tw-translate-x: 0;
        --tw-translate-y: 0;
        --tw-rotate: 0;
        --tw-skew-x: 0;
        --tw-skew-y: 0;
        --tw-scale-x: 1;
        --tw-scale-y: 1;
        --tw-pan-x: ;
        --tw-pan-y: ;
        --tw-pinch-zoom: ;
        --tw-scroll-snap-strictness: proximity;
        --tw-gradient-from-position: ;
        --tw-gradient-via-position: ;
        --tw-gradient-to-position: ;
        --tw-ordinal: ;
        --tw-slashed-zero: ;
        --tw-numeric-figure: ;
        --tw-numeric-spacing: ;
        --tw-numeric-fraction: ;
        --tw-ring-inset: ;
        --tw-ring-offset-width: 0px;
        --tw-ring-offset-color: #fff;
        --tw-ring-color: rgb(59 130 246 / .5);
        --tw-ring-offset-shadow: 0 0 #0000;
        --tw-ring-shadow: 0 0 #0000;
        --tw-shadow: 0 0 #0000;
        --tw-shadow-colored: 0 0 #0000;
        --tw-blur: ;
        --tw-brightness: ;
        --tw-contrast: ;
        --tw-grayscale: ;
        --tw-hue-rotate: ;
        --tw-invert: ;
        --tw-saturate: ;
        --tw-sepia: ;
        --tw-drop-shadow: ;
        --tw-backdrop-blur: ;
        --tw-backdrop-brightness: ;
        --tw-backdrop-contrast: ;
        --tw-backdrop-grayscale: ;
        --tw-backdrop-hue-rotate: ;
        --tw-backdrop-invert: ;
        --tw-backdrop-opacity: ;
        --tw-backdrop-saturate: ;
        --tw-backdrop-sepia:
    }

    .alert {
        display: grid;
        width: 100%;
        grid-auto-flow: row;
        align-content: flex-start;
        align-items: center;
        justify-items: center;
        gap: 1rem;
        text-align: center;
        border-radius: var(--rounded-box, 1rem);
        border-width: 1px;
        --tw-border-opacity: 1;
        border-color: var(--fallback-b2, oklch(var(--b2)/var(--tw-border-opacity)));
        padding: 1rem;
        --tw-text-opacity: 1;
        color: var(--fallback-bc, oklch(var(--bc)/var(--tw-text-opacity)));
        --alert-bg: var(--fallback-b2, oklch(var(--b2)/1));
        --alert-bg-mix: var(--fallback-b1, oklch(var(--b1)/1));
        background-color: var(--alert-bg)
    }

    @media (min-width: 640px) {
        .alert {
            grid-auto-flow: column;
            grid-template-columns: auto minmax(auto, 1fr);
            justify-items: start;
            text-align: start
        }
    }

    .avatar {
        position: relative;
        display: inline-flex
    }

    .avatar>div {
        display: block;
        aspect-ratio: 1 / 1;
        overflow: hidden
    }

    .avatar img {
        height: 100%;
        width: 100%;
        -o-object-fit: cover;
        object-fit: cover
    }

    .avatar.placeholder>div {
        display: flex;
        align-items: center;
        justify-content: center
    }

    .badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, -webkit-backdrop-filter;
        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter, -webkit-backdrop-filter;
        transition-timing-function: cubic-bezier(.4, 0, .2, 1);
        transition-timing-function: cubic-bezier(0, 0, .2, 1);
        transition-duration: .2s;
        height: 1.25rem;
        font-size: .875rem;
        line-height: 1.25rem;
        width: -moz-fit-content;
        width: fit-content;
        padding-left: .563rem;
        padding-right: .563rem;
        border-radius: var(--rounded-badge, 1.9rem);
        border-width: 1px;
        --tw-border-opacity: 1;
        border-color: var(--fallback-b2, oklch(var(--b2)/var(--tw-border-opacity)));
        --tw-bg-opacity: 1;
        background-color: var(--fallback-b1, oklch(var(--b1)/var(--tw-bg-opacity)));
        --tw-text-opacity: 1;
        color: var(--fallback-bc, oklch(var(--bc)/var(--tw-text-opacity)))
    }

    @media (hover:hover) {
        .checkbox-primary:hover {
            --tw-border-opacity: 1;
            border-color: var(--fallback-p, oklch(var(--p)/var(--tw-border-opacity)))
        }

        .checkbox-info:hover {
            --tw-border-opacity: 1;
            border-color: var(--fallback-in, oklch(var(--in)/var(--tw-border-opacity)))
        }

        .label a:hover {
            --tw-text-opacity: 1;
            color: var(--fallback-bc, oklch(var(--bc)/var(--tw-text-opacity)))
        }

        .menu li>*:not(ul, .menu-title, details, .btn):active,
        .menu li>*:not(ul, .menu-title, details, .btn).active,
        .menu li>details>summary:active {
            --tw-bg-opacity: 1;
            background-color: var(--fallback-n, oklch(var(--n)/var(--tw-bg-opacity)));
            --tw-text-opacity: 1;
            color: var(--fallback-nc, oklch(var(--nc)/var(--tw-text-opacity)))
        }

        .table tr.hover:hover,
        .table tr.hover:nth-child(even):hover {
            --tw-bg-opacity: 1;
            background-color: var(--fallback-b2, oklch(var(--b2)/var(--tw-bg-opacity)))
        }
    }

    .btn {
        display: inline-flex;
        height: 3rem;
        min-height: 3rem;
        flex-shrink: 0;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        border-radius: var(--rounded-btn, .5rem);
        border-color: transparent;
        border-color: oklch(var(--btn-color, var(--b2)) / var(--tw-border-opacity));
        padding-left: 1rem;
        padding-right: 1rem;
        text-align: center;
        font-size: .875rem;
        line-height: 1em;
        gap: .5rem;
        font-weight: 600;
        text-decoration-line: none;
        transition-duration: .2s;
        transition-timing-function: cubic-bezier(0, 0, .2, 1);
        border-width: var(--border-btn, 1px);
        transition-property: color, background-color, border-color, opacity, box-shadow, transform;
        --tw-text-opacity: 1;
        color: var(--fallback-bc, oklch(var(--bc)/var(--tw-text-opacity)));
        --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / .05);
        --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
        outline-color: var(--fallback-bc, oklch(var(--bc)/1));
        background-color: oklch(var(--btn-color, var(--b2)) / var(--tw-bg-opacity));
        --tw-bg-opacity: 1;

        --tw-border-opacity: 1}.btn-disabled,.btn[disabled],.btn:disabled{pointer-events:none}.btn-circle{height:3rem;width:3rem;border-radius:9999px;padding:0}:where(.btn:is(input[type="checkbox"])), :where(.btn:is(input[type="radio"])) {
            width: auto;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none
        }

        .btn:is(input[type="checkbox"]):after,
        .btn:is(input[type="radio"]):after {
            --tw-content: attr(aria-label);
            content: var(--tw-content)
        }

        .checkbox {
            flex-shrink: 0;
            --chkbg: var(--fallback-bc, oklch(var(--bc)/1));
            --chkfg: var(--fallback-b1, oklch(var(--b1)/1));
            height: 1.5rem;
            width: 1.5rem;
            cursor: pointer;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: var(--rounded-btn, .5rem);
            border-width: 1px;
            border-color: var(--fallback-bc, oklch(var(--bc)/var(--tw-border-opacity)));
            --tw-border-opacity: .2
        }

        .collapse:not(td):not(tr):not(colgroup) {
            visibility: visible
        }

        .collapse {
            position: relative;
            display: grid;
            overflow: hidden;
            grid-template-rows: auto 0fr;
            transition: grid-template-rows .2s;
            width: 100%;
            border-radius: var(--rounded-box, 1rem)
        }

        .collapse-title,
        .collapse>input[type=checkbox],
        .collapse>input[type=radio],
        .collapse-content {
            grid-column-start: 1;
            grid-row-start: 1
        }

        .collapse>input[type=checkbox],
        .collapse>input[type=radio] {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            opacity: 0
        }

        .collapse[open],
        .collapse-open,
        .collapse:focus:not(.collapse-close) {
            grid-template-rows: auto 1fr
        }

        .collapse:not(.collapse-close):has(> input[type="checkbox"]:checked),
        .collapse:not(.collapse-close):has(> input[type="radio"]:checked) {
            grid-template-rows: auto 1fr
        }

        .collapse[open]>.collapse-content,
        .collapse-open>.collapse-content,
        .collapse:focus:not(.collapse-close)>.collapse-content,
        .collapse:not(.collapse-close)>input[type=checkbox]:checked~.collapse-content,
        .collapse:not(.collapse-close)>input[type=radio]:checked~.collapse-content {
            visibility: visible;
            min-height: -moz-fit-content;
            min-height: fit-content
        }

        .divider {
            display: flex;
            flex-direction: row;
            align-items: center;
            align-self: stretch;
            margin-top: 1rem;
            margin-bottom: 1rem;
            height: 1rem;
            white-space: nowrap
        }

        .divider:before,
        .divider:after {
            height: .125rem;
            width: 100%;
            flex-grow: 1;
            --tw-content: "";
            content: var(--tw-content);
            background-color: var(--fallback-bc, oklch(var(--bc)/.1))
        }

        .dropdown {
            position: relative;
            display: inline-block
        }

        .dropdown>*:not(summary):focus {
            outline: 2px solid transparent;
            outline-offset: 2px
        }

        .dropdown .dropdown-content {
            position: absolute
        }

        .dropdown:is(:not(details)) .dropdown-content {
            visibility: hidden;
            opacity: 0;
            transform-origin: top;
            --tw-scale-x: .95;
            --tw-scale-y: .95;
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, -webkit-backdrop-filter;
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter, -webkit-backdrop-filter;
            transition-timing-function: cubic-bezier(.4, 0, .2, 1);
            transition-timing-function: cubic-bezier(0, 0, .2, 1);
            transition-duration: .2s
        }

        .dropdown-end .dropdown-content {
            inset-inline-end: 0px
        }

        .dropdown-left .dropdown-content {
            bottom: auto;
            inset-inline-end: 100%;
            top: 0px;
            transform-origin: right
        }

        .dropdown-right .dropdown-content {
            bottom: auto;
            inset-inline-start: 100%;
            top: 0px;
            transform-origin: left
        }

        .dropdown-bottom .dropdown-content {
            bottom: auto;
            top: 100%;
            transform-origin: top
        }

        .dropdown-top .dropdown-content {
            bottom: 100%;
            top: auto;
            transform-origin: bottom
        }

        .dropdown-end.dropdown-right .dropdown-content,
        .dropdown-end.dropdown-left .dropdown-content {
            bottom: 0px;
            top: auto
        }

        .dropdown.dropdown-open .dropdown-content,
        .dropdown:not(.dropdown-hover):focus .dropdown-content,
        .dropdown:focus-within .dropdown-content {
            visibility: visible;
            opacity: 1
        }

        @media (hover: hover) {
            .dropdown.dropdown-hover:hover .dropdown-content {
                visibility: visible;
                opacity: 1
            }

            .btm-nav>*.disabled:hover,
            .btm-nav>*[disabled]:hover {
                pointer-events: none;
                --tw-border-opacity: 0;
                background-color: var(--fallback-n, oklch(var(--n)/var(--tw-bg-opacity)));
                --tw-bg-opacity: .1;
                color: var(--fallback-bc, oklch(var(--bc)/var(--tw-text-opacity)));
                --tw-text-opacity: .2
            }

            .btn:hover {
                --tw-border-opacity: 1;
                border-color: var(--fallback-b3, oklch(var(--b3)/var(--tw-border-opacity)));
                --tw-bg-opacity: 1;
                background-color: var(--fallback-b3, oklch(var(--b3)/var(--tw-bg-opacity)))
            }

            @supports (color: color-mix(in oklab, black, black)) {
                .btn:hover {
                    background-color: color-mix(in oklab, oklch(var(--btn-color, var(--b2)) / var(--tw-bg-opacity, 1)) 90%, black);
                    border-color: color-mix(in oklab, oklch(var(--btn-color, var(--b2)) / var(--tw-border-opacity, 1)) 90%, black)
                }
            }

            @supports not (color: oklch(0% 0 0)) {
                .btn:hover {
                    background-color: var(--btn-color, var(--fallback-b2));
                    border-color: var(--btn-color, var(--fallback-b2))
                }
            }

            .btn.glass:hover {
                --glass-opacity: 25%;
                --glass-border-opacity: 15%
            }

            .btn-ghost:hover {
                border-color: transparent
            }

            @supports (color: oklch(0% 0 0)) {
                .btn-ghost:hover {
                    background-color: var(--fallback-bc, oklch(var(--bc)/.2))
                }
            }

            .btn-outline:hover {
                --tw-border-opacity: 1;
                border-color: var(--fallback-bc, oklch(var(--bc)/var(--tw-border-opacity)));
                --tw-bg-opacity: 1;
                background-color: var(--fallback-bc, oklch(var(--bc)/var(--tw-bg-opacity)));
                --tw-text-opacity: 1;
                color: var(--fallback-b1, oklch(var(--b1)/var(--tw-text-opacity)))
            }

            .btn-outline.btn-primary:hover {
                --tw-text-opacity: 1;
                color: var(--fallback-pc, oklch(var(--pc)/var(--tw-text-opacity)))
            }

            @supports (color: color-mix(in oklab, black, black)) {
                .btn-outline.btn-primary:hover {
                    background-color: color-mix(in oklab, var(--fallback-p, oklch(var(--p)/1)) 90%, black);
                    border-color: color-mix(in oklab, var(--fallback-p, oklch(var(--p)/1)) 90%, black)
                }
            }

            .btn-outline.btn-secondary:hover {
                --tw-text-opacity: 1;
                color: var(--fallback-sc, oklch(var(--sc)/var(--tw-text-opacity)))
            }

            @supports (color: color-mix(in oklab, black, black)) {
                .btn-outline.btn-secondary:hover {
                    background-color: color-mix(in oklab, var(--fallback-s, oklch(var(--s)/1)) 90%, black);
                    border-color: color-mix(in oklab, var(--fallback-s, oklch(var(--s)/1)) 90%, black)
                }
            }

            .btn-outline.btn-accent:hover {
                --tw-text-opacity: 1;
                color: var(--fallback-ac, oklch(var(--ac)/var(--tw-text-opacity)))
            }

            @supports (color: color-mix(in oklab, black, black)) {
                .btn-outline.btn-accent:hover {
                    background-color: color-mix(in oklab, var(--fallback-a, oklch(var(--a)/1)) 90%, black);
                    border-color: color-mix(in oklab, var(--fallback-a, oklch(var(--a)/1)) 90%, black)
                }
            }

            .btn-outline.btn-success:hover {
                --tw-text-opacity: 1;
                color: var(--fallback-suc, oklch(var(--suc)/var(--tw-text-opacity)))
            }

            @supports (color: color-mix(in oklab, black, black)) {
                .btn-outline.btn-success:hover {
                    background-color: color-mix(in oklab, var(--fallback-su, oklch(var(--su)/1)) 90%, black);
                    border-color: color-mix(in oklab, var(--fallback-su, oklch(var(--su)/1)) 90%, black)
                }
            }

            .btn-outline.btn-info:hover {
                --tw-text-opacity: 1;
                color: var(--fallback-inc, oklch(var(--inc)/var(--tw-text-opacity)))
            }

            @supports (color: color-mix(in oklab, black, black)) {
                .btn-outline.btn-info:hover {
                    background-color: color-mix(in oklab, var(--fallback-in, oklch(var(--in)/1)) 90%, black);
                    border-color: color-mix(in oklab, var(--fallback-in, oklch(var(--in)/1)) 90%, black)
                }
            }

            .btn-outline.btn-warning:hover {
                --tw-text-opacity: 1;
                color: var(--fallback-wac, oklch(var(--wac)/var(--tw-text-opacity)))
            }

            @supports (color: color-mix(in oklab, black, black)) {
                .btn-outline.btn-warning:hover {
                    background-color: color-mix(in oklab, var(--fallback-wa, oklch(var(--wa)/1)) 90%, black);
                    border-color: color-mix(in oklab, var(--fallback-wa, oklch(var(--wa)/1)) 90%, black)
                }
            }

            .btn-outline.btn-error:hover {
                --tw-text-opacity: 1;
                color: var(--fallback-erc, oklch(var(--erc)/var(--tw-text-opacity)))
            }

            @supports (color: color-mix(in oklab, black, black)) {
                .btn-outline.btn-error:hover {
                    background-color: color-mix(in oklab, var(--fallback-er, oklch(var(--er)/1)) 90%, black);
                    border-color: color-mix(in oklab, var(--fallback-er, oklch(var(--er)/1)) 90%, black)
                }
            }

            .btn-disabled:hover,
            .btn[disabled]:hover,
            .btn:disabled:hover {
                --tw-border-opacity: 0;
                background-color: var(--fallback-n, oklch(var(--n)/var(--tw-bg-opacity)));
                --tw-bg-opacity: .2;
                color: var(--fallback-bc, oklch(var(--bc)/var(--tw-text-opacity)));
                --tw-text-opacity: .2
            }

            @supports (color: color-mix(in oklab,black,black)){.btn:is(input[type="checkbox"]:checked):hover, .btn:is(input[type="radio"]:checked):hover {
                background-color: color-mix(in oklab, var(--fallback-p, oklch(var(--p)/1)) 90%, black);
                border-color: color-mix(in oklab, var(--fallback-p, oklch(var(--p)/1)) 90%, black)
            }
        }

        .dropdown.dropdown-hover:hover .dropdown-content {
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
        }

        :where(.menu li:not(.menu-title, .disabled) > *:not(ul, details, .menu-title)):not(.active, .btn):hover,
        :where(.menu li:not(.menu-title, .disabled) > details > summary:not(.menu-title)):not(.active, .btn):hover {
            cursor: pointer;
            outline: 2px solid transparent;
            outline-offset: 2px
        }

        @supports (color: oklch(0% 0 0)) {

            :where(.menu li:not(.menu-title, .disabled) > *:not(ul, details, .menu-title)):not(.active, .btn):hover,
            :where(.menu li:not(.menu-title, .disabled) > details > summary:not(.menu-title)):not(.active, .btn):hover {
                background-color: var(--fallback-bc, oklch(var(--bc)/.1))
            }
        }
    }

    .dropdown:is(details) summary::-webkit-details-marker {
        display: none
    }

    .file-input {
        height: 3rem;
        flex-shrink: 1;
        padding-inline-end: 1rem;
        font-size: 1rem;
        line-height: 2;
        line-height: 1.5rem;
        overflow: hidden;
        border-radius: var(--rounded-btn, .5rem);
        border-width: 1px;
        border-color: var(--fallback-bc, oklch(var(--bc)/var(--tw-border-opacity)));
        --tw-border-opacity: 0;
        --tw-bg-opacity: 1;
        background-color: var(--fallback-b1, oklch(var(--b1)/var(--tw-bg-opacity)))
    }

    .file-input::file-selector-button {
        margin-inline-end: 1rem;
        display: inline-flex;
        height: 100%;
        flex-shrink: 0;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        padding-left: 1rem;
        padding-right: 1rem;
        text-align: center;
        font-size: .875rem;
        line-height: 1.25rem;
        line-height: 1em;
        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, -webkit-backdrop-filter;
        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter, -webkit-backdrop-filter;
        transition-timing-function: cubic-bezier(.4, 0, .2, 1);
        transition-timing-function: cubic-bezier(0, 0, .2, 1);
        transition-duration: .2s;
        border-style: solid;
        --tw-border-opacity: 1;
        border-color: var(--fallback-n, oklch(var(--n)/var(--tw-border-opacity)));
        --tw-bg-opacity: 1;
        background-color: var(--fallback-n, oklch(var(--n)/var(--tw-bg-opacity)));
        font-weight: 600;
        text-transform: uppercase;
        --tw-text-opacity: 1;
        color: var(--fallback-nc, oklch(var(--nc)/var(--tw-text-opacity)));
        text-decoration-line: none;
        border-width: var(--border-btn, 1px);
        animation: button-pop var(--animation-btn, .25s) ease-out
    }

    .footer {
        display: grid;
        width: 100%;
        grid-auto-flow: row;
        place-items: start;
        -moz-column-gap: 1rem;
        column-gap: 1rem;
        row-gap: 2.5rem;
        font-size: .875rem;
        line-height: 1.25rem
    }

    .footer>* {
        display: grid;
        place-items: start;
        gap: .5rem
    }

    @media (min-width: 48rem) {
        .footer {
            grid-auto-flow: column
        }

        .footer-center {
            grid-auto-flow: row dense
        }
    }

    .form-control {
        display: flex;
        flex-direction: column
    }

    .label {
        display: flex;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
        align-items: center;
        justify-content: space-between;
        padding: .5rem .25rem
    }

    .indicator {
        position: relative;
        display: inline-flex;
        width: -moz-max-content;
        width: max-content
    }

    .indicator :where(.indicator-item) {
        z-index: 1;
        position: absolute;
        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
        white-space: nowrap
    }

    .input {
        flex-shrink: 1;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        height: 3rem;
        padding-left: 1rem;
        padding-right: 1rem;
        font-size: 1rem;
        line-height: 2;
        line-height: 1.5rem;
        border-radius: var(--rounded-btn, .5rem);
        border-width: 1px;
        border-color: transparent;
        --tw-bg-opacity: 1;
        background-color: var(--fallback-b1, oklch(var(--b1)/var(--tw-bg-opacity)))
    }

    .input[type=number]::-webkit-inner-spin-button,
    .input-md[type=number]::-webkit-inner-spin-button {
        margin-top: -1rem;
        margin-bottom: -1rem;
        margin-inline-end: -1rem
    }

    .input-sm[type=number]::-webkit-inner-spin-button {
        margin-top: 0;
        margin-bottom: 0;
        margin-inline-end: -0px
    }

    .join {
        display: inline-flex;
        align-items: stretch;
        border-radius: var(--rounded-btn, .5rem)
    }

    .join :where(.join-item) {
        border-start-end-radius: 0;
        border-end-end-radius: 0;
        border-end-start-radius: 0;
        border-start-start-radius: 0
    }

    .join .join-item:not(:first-child):not(:last-child),
    .join *:not(:first-child):not(:last-child) .join-item {
        border-start-end-radius: 0;
        border-end-end-radius: 0;
        border-end-start-radius: 0;
        border-start-start-radius: 0
    }

    .join .join-item:first-child:not(:last-child),
    .join *:first-child:not(:last-child) .join-item {
        border-start-end-radius: 0;
        border-end-end-radius: 0
    }

    .join .dropdown .join-item:first-child:not(:last-child),
    .join *:first-child:not(:last-child) .dropdown .join-item {
        border-start-end-radius: inherit;
        border-end-end-radius: inherit
    }

    .join :where(.join-item:first-child:not(:last-child)),
    .join :where(*:first-child:not(:last-child) .join-item) {
        border-end-start-radius: inherit;
        border-start-start-radius: inherit
    }

    .join .join-item:last-child:not(:first-child),
    .join *:last-child:not(:first-child) .join-item {
        border-end-start-radius: 0;
        border-start-start-radius: 0
    }

    .join :where(.join-item:last-child:not(:first-child)),
    .join :where(*:last-child:not(:first-child) .join-item) {
        border-start-end-radius: inherit;
        border-end-end-radius: inherit
    }

    @supports not selector(:has(*)) {
        :where(.join *) {
            border-radius: inherit
        }
    }

    @supports selector(:has(*)) {
        :where(.join *:has(.join-item)) {
            border-radius: inherit
        }
    }

    .link {
        cursor: pointer;
        text-decoration-line: underline
    }

    .menu {
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        font-size: .875rem;
        line-height: 1.25rem;
        padding: .5rem
    }

    .menu :where(li ul) {
        position: relative;
        white-space: nowrap;
        margin-inline-start: 1rem;
        padding-inline-start: .5rem
    }

    .menu :where(li:not(.menu-title) > *:not(ul, details, .menu-title, .btn)),
    .menu :where(li:not(.menu-title) > details > summary:not(.menu-title)) {
        display: grid;
        grid-auto-flow: column;
        align-content: flex-start;
        align-items: center;
        gap: .5rem;
        grid-auto-columns: minmax(auto, max-content) auto max-content;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none
    }

    .menu li.disabled {
        cursor: not-allowed;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
        color: var(--fallback-bc, oklch(var(--bc)/.3))
    }

    .menu :where(li > .menu-dropdown:not(.menu-dropdown-show)) {
        display: none
    }

    :where(.menu li) {
        position: relative;
        display: flex;
        flex-shrink: 0;
        flex-direction: column;
        flex-wrap: wrap;
        align-items: stretch
    }

    :where(.menu li) .badge {
        justify-self: end
    }

    .modal {
        pointer-events: none;
        position: fixed;
        inset: 0px;
        margin: 0;
        display: grid;
        height: 100%;
        max-height: none;
        width: 100%;
        max-width: none;
        justify-items: center;
        padding: 0;
        opacity: 0;
        overscroll-behavior: contain;
        z-index: 999;
        background-color: transparent;
        color: inherit;
        transition-duration: .2s;
        transition-timing-function: cubic-bezier(0, 0, .2, 1);
        transition-property: transform, opacity, visibility;
        overflow-y: hidden
    }

    :where(.modal) {
        align-items: center
    }

    .modal-box {
        max-height: calc(100vh - 5em);
        grid-column-start: 1;
        grid-row-start: 1;
        width: 91.666667%;
        max-width: 32rem;
        --tw-scale-x: .9;
        --tw-scale-y: .9;
        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
        border-bottom-right-radius: var(--rounded-box, 1rem);
        border-bottom-left-radius: var(--rounded-box, 1rem);
        border-top-left-radius: var(--rounded-box, 1rem);
        border-top-right-radius: var(--rounded-box, 1rem);
        --tw-bg-opacity: 1;
        background-color: var(--fallback-b1, oklch(var(--b1)/var(--tw-bg-opacity)));
        padding: 1.5rem;
        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, -webkit-backdrop-filter;
        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter, -webkit-backdrop-filter;
        transition-timing-function: cubic-bezier(.4, 0, .2, 1);
        transition-timing-function: cubic-bezier(0, 0, .2, 1);
        transition-duration: .2s;
        box-shadow: #00000040 0 25px 50px -12px;
        overflow-y: auto;
        overscroll-behavior: contain
    }

    .modal-open,
    .modal:target,
    .modal-toggle:checked+.modal,
    .modal[open] {
        pointer-events: auto;
        visibility: visible;
        opacity: 1
    }

    :root:has(:is(.modal-open, .modal:target, .modal-toggle:checked + .modal, .modal[open])) {
        overflow: hidden;
        scrollbar-gutter: stable
    }

    .navbar {
        display: flex;
        align-items: center;
        padding: var(--navbar-padding, .5rem);
        min-height: 4rem;
        width: 100%
    }

    :where(.navbar > *:not(script, style)) {
        display: inline-flex;
        align-items: center
    }

    .progress {
        position: relative;
        width: 100%;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        overflow: hidden;
        height: .5rem;
        border-radius: var(--rounded-box, 1rem);
        background-color: var(--fallback-bc, oklch(var(--bc)/.2))
    }

    .select {
        display: inline-flex;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        height: 3rem;
        min-height: 3rem;
        padding-inline-start: 1rem;
        padding-inline-end: 2.5rem;
        font-size: .875rem;
        line-height: 1.25rem;
        line-height: 2;
        border-radius: var(--rounded-btn, .5rem);
        border-width: 1px;
        border-color: transparent;
        --tw-bg-opacity: 1;
        background-color: var(--fallback-b1, oklch(var(--b1)/var(--tw-bg-opacity)));
        background-image: linear-gradient(45deg, transparent 50%, currentColor 50%), linear-gradient(135deg, currentColor 50%, transparent 50%);
        background-position: calc(100% - 20px) calc(1px + 50%), calc(100% - 16.1px) calc(1px + 50%);
        background-size: 4px 4px, 4px 4px;
        background-repeat: no-repeat
    }

    .select[multiple] {
        height: auto
    }

    .swap {
        position: relative;
        display: inline-grid;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
        place-content: center;
        cursor: pointer
    }

    .swap>* {
        grid-column-start: 1;
        grid-row-start: 1;
        transition-duration: .3s;
        transition-timing-function: cubic-bezier(0, 0, .2, 1);
        transition-property: transform, opacity
    }

    .swap input {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none
    }

    .swap .swap-on,
    .swap .swap-indeterminate,
    .swap input:indeterminate~.swap-on {
        opacity: 0
    }

    .swap input:checked~.swap-off,
    .swap-active .swap-off,
    .swap input:indeterminate~.swap-off {
        opacity: 0
    }

    .swap input:checked~.swap-on,
    .swap-active .swap-on,
    .swap input:indeterminate~.swap-indeterminate {
        opacity: 1
    }

    .table {
        position: relative;
        width: 100%;
        border-radius: var(--rounded-box, 1rem);
        text-align: left;
        font-size: .875rem;
        line-height: 1.25rem
    }

    .table :where(.table-pin-rows thead tr) {
        position: sticky;
        top: 0px;
        z-index: 1;
        --tw-bg-opacity: 1;
        background-color: var(--fallback-b1, oklch(var(--b1)/var(--tw-bg-opacity)))
    }

    .table :where(.table-pin-rows tfoot tr) {
        position: sticky;
        bottom: 0px;
        z-index: 1;
        --tw-bg-opacity: 1;
        background-color: var(--fallback-b1, oklch(var(--b1)/var(--tw-bg-opacity)))
    }

    .table :where(.table-pin-cols tr th) {
        position: sticky;
        left: 0px;
        right: 0px;
        --tw-bg-opacity: 1;
        background-color: var(--fallback-b1, oklch(var(--b1)/var(--tw-bg-opacity)))
    }

    .table-zebra tbody tr:nth-child(even) :where(.table-pin-cols tr th) {
        --tw-bg-opacity: 1;
        background-color: var(--fallback-b2, oklch(var(--b2)/var(--tw-bg-opacity)))
    }

    .textarea {
        min-height: 3rem;
        flex-shrink: 1;
        padding: .5rem 1rem;
        font-size: .875rem;
        line-height: 1.25rem;
        line-height: 2;
        border-radius: var(--rounded-btn, .5rem);
        border-width: 1px;
        border-color: transparent;
        --tw-bg-opacity: 1;
        background-color: var(--fallback-b1, oklch(var(--b1)/var(--tw-bg-opacity)))
    }

    .timeline {
        position: relative;
        display: flex
    }

    :where(.timeline > li) {
        position: relative;
        display: grid;
        flex-shrink: 0;
        align-items: center;
        grid-template-rows: var(--timeline-row-start, minmax(0, 1fr)) auto var(--timeline-row-end, minmax(0, 1fr));
        grid-template-columns: var(--timeline-col-start, minmax(0, 1fr)) auto var(--timeline-col-end, minmax(0, 1fr))
    }

    .timeline>li>hr {
        width: 100%;
        border-width: 0px
    }

    :where(.timeline > li > hr):first-child {
        grid-column-start: 1;
        grid-row-start: 2
    }

    :where(.timeline > li > hr):last-child {
        grid-column-start: 3;
        grid-column-end: none;
        grid-row-start: 2;
        grid-row-end: auto
    }

    .timeline-middle {
        grid-column-start: 2;
        grid-row-start: 2
    }

    .timeline-end {
        grid-column-start: 1;
        grid-column-end: 4;
        grid-row-start: 3;
        grid-row-end: 4;
        margin: .25rem;
        align-self: flex-start;
        justify-self: center
    }

    .toggle {
        flex-shrink: 0;
        --tglbg: var(--fallback-b1, oklch(var(--b1)/1));
        --handleoffset: 1.5rem;
        --handleoffsetcalculator: calc(var(--handleoffset) * -1);
        --togglehandleborder: 0 0;
        height: 1.5rem;
        width: 3rem;
        cursor: pointer;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: var(--rounded-badge, 1.9rem);
        border-width: 1px;
        border-color: currentColor;
        background-color: currentColor;
        color: var(--fallback-bc, oklch(var(--bc)/.5));
        transition: background, box-shadow var(--animation-input, .2s) ease-out;
        box-shadow: var(--handleoffsetcalculator) 0 0 2px var(--tglbg) inset, 0 0 0 2px var(--tglbg) inset, var(--togglehandleborder)
    }

    .alert-success {
        border-color: var(--fallback-su, oklch(var(--su)/.2));
        --tw-text-opacity: 1;
        color: var(--fallback-suc, oklch(var(--suc)/var(--tw-text-opacity)));
        --alert-bg: var(--fallback-su, oklch(var(--su)/1));
        --alert-bg-mix: var(--fallback-b1, oklch(var(--b1)/1))
    }

    .alert-warning {
        border-color: var(--fallback-wa, oklch(var(--wa)/.2));
        --tw-text-opacity: 1;
        color: var(--fallback-wac, oklch(var(--wac)/var(--tw-text-opacity)));
        --alert-bg: var(--fallback-wa, oklch(var(--wa)/1));
        --alert-bg-mix: var(--fallback-b1, oklch(var(--b1)/1))
    }

    .alert-error {
        border-color: var(--fallback-er, oklch(var(--er)/.2));
        --tw-text-opacity: 1;
        color: var(--fallback-erc, oklch(var(--erc)/var(--tw-text-opacity)));
        --alert-bg: var(--fallback-er, oklch(var(--er)/1));
        --alert-bg-mix: var(--fallback-b1, oklch(var(--b1)/1))
    }

    .avatar-group :where(.avatar) {
        overflow: hidden;
        border-radius: 9999px;
        border-width: 4px;
        --tw-border-opacity: 1;
        border-color: var(--fallback-b1, oklch(var(--b1)/var(--tw-border-opacity)))
    }

    .badge-primary {
        --tw-border-opacity: 1;
        border-color: var(--fallback-p, oklch(var(--p)/var(--tw-border-opacity)));
        --tw-bg-opacity: 1;
        background-color: var(--fallback-p, oklch(var(--p)/var(--tw-bg-opacity)));
        --tw-text-opacity: 1;
        color: var(--fallback-pc, oklch(var(--pc)/var(--tw-text-opacity)))
    }

    .badge-info {
        border-color: transparent;
        --tw-bg-opacity: 1;
        background-color: var(--fallback-in, oklch(var(--in)/var(--tw-bg-opacity)));
        --tw-text-opacity: 1;
        color: var(--fallback-inc, oklch(var(--inc)/var(--tw-text-opacity)))
    }

    .badge-outline.badge-primary {
        --tw-text-opacity: 1;
        color: var(--fallback-p, oklch(var(--p)/var(--tw-text-opacity)))
    }

    .badge-outline.badge-info {
        --tw-text-opacity: 1;
        color: var(--fallback-in, oklch(var(--in)/var(--tw-text-opacity)))
    }

    .btm-nav>*.disabled,
    .btm-nav>*[disabled] {
        pointer-events: none;
        --tw-border-opacity: 0;
        background-color: var(--fallback-n, oklch(var(--n)/var(--tw-bg-opacity)));
        --tw-bg-opacity: .1;
        color: var(--fallback-bc, oklch(var(--bc)/var(--tw-text-opacity)));
        --tw-text-opacity: .2
    }

    .btm-nav>* .label {
        font-size: 1rem;
        line-height: 1.5rem
    }

    @media (prefers-reduced-motion: no-preference) {
        .btn {
            animation: button-pop var(--animation-btn, .25s) ease-out
        }
    }

    .btn:active:hover,
    .btn:active:focus {
        animation: button-pop 0s ease-out;
        transform: scale(var(--btn-focus-scale, .97))
    }

    @supports not (color: oklch(0% 0 0)) {
        .btn {
            background-color: var(--btn-color, var(--fallback-b2));
            border-color: var(--btn-color, var(--fallback-b2))
        }

        .btn-primary {
            --btn-color: var(--fallback-p)
        }

        .btn-accent {
            --btn-color: var(--fallback-a)
        }

        .btn-neutral {
            --btn-color: var(--fallback-n)
        }

        .btn-info {
            --btn-color: var(--fallback-in)
        }

        .btn-success {
            --btn-color: var(--fallback-su)
        }

        .btn-error {
            --btn-color: var(--fallback-er)
        }
    }

    @supports (color: color-mix(in oklab, black, black)) {
        .btn-active {
            background-color: color-mix(in oklab, oklch(var(--btn-color, var(--b3)) / var(--tw-bg-opacity, 1)) 90%, black);
            border-color: color-mix(in oklab, oklch(var(--btn-color, var(--b3)) / var(--tw-border-opacity, 1)) 90%, black)
        }

        .btn-outline.btn-primary.btn-active {
            background-color: color-mix(in oklab, var(--fallback-p, oklch(var(--p)/1)) 90%, black);
            border-color: color-mix(in oklab, var(--fallback-p, oklch(var(--p)/1)) 90%, black)
        }

        .btn-outline.btn-secondary.btn-active {
            background-color: color-mix(in oklab, var(--fallback-s, oklch(var(--s)/1)) 90%, black);
            border-color: color-mix(in oklab, var(--fallback-s, oklch(var(--s)/1)) 90%, black)
        }

        .btn-outline.btn-accent.btn-active {
            background-color: color-mix(in oklab, var(--fallback-a, oklch(var(--a)/1)) 90%, black);
            border-color: color-mix(in oklab, var(--fallback-a, oklch(var(--a)/1)) 90%, black)
        }

        .btn-outline.btn-success.btn-active {
            background-color: color-mix(in oklab, var(--fallback-su, oklch(var(--su)/1)) 90%, black);
            border-color: color-mix(in oklab, var(--fallback-su, oklch(var(--su)/1)) 90%, black)
        }

        .btn-outline.btn-info.btn-active {
            background-color: color-mix(in oklab, var(--fallback-in, oklch(var(--in)/1)) 90%, black);
            border-color: color-mix(in oklab, var(--fallback-in, oklch(var(--in)/1)) 90%, black)
        }

        .btn-outline.btn-warning.btn-active {
            background-color: color-mix(in oklab, var(--fallback-wa, oklch(var(--wa)/1)) 90%, black);
            border-color: color-mix(in oklab, var(--fallback-wa, oklch(var(--wa)/1)) 90%, black)
        }

        .btn-outline.btn-error.btn-active {
            background-color: color-mix(in oklab, var(--fallback-er, oklch(var(--er)/1)) 90%, black);
            border-color: color-mix(in oklab, var(--fallback-er, oklch(var(--er)/1)) 90%, black)
        }
    }

    .btn:focus-visible {
        outline-style: solid;
        outline-width: 2px;
        outline-offset: 2px
    }

    .btn-primary {
        --tw-text-opacity: 1;
        color: var(--fallback-pc, oklch(var(--pc)/var(--tw-text-opacity)));
        outline-color: var(--fallback-p, oklch(var(--p)/1))
    }

    @supports (color: oklch(0% 0 0)) {
        .btn-primary {
            --btn-color: var(--p)
        }

        .btn-accent {
            --btn-color: var(--a)
        }

        .btn-neutral {
            --btn-color: var(--n)
        }

        .btn-info {
            --btn-color: var(--in)
        }

        .btn-success {
            --btn-color: var(--su)
        }

        .btn-error {
            --btn-color: var(--er)
        }
    }

    .btn-accent {
        --tw-text-opacity: 1;
        color: var(--fallback-ac, oklch(var(--ac)/var(--tw-text-opacity)));
        outline-color: var(--fallback-a, oklch(var(--a)/1))
    }

    .btn-neutral {
        --tw-text-opacity: 1;
        color: var(--fallback-nc, oklch(var(--nc)/var(--tw-text-opacity)));
        outline-color: var(--fallback-n, oklch(var(--n)/1))
    }

    .btn-info {
        --tw-text-opacity: 1;
        color: var(--fallback-inc, oklch(var(--inc)/var(--tw-text-opacity)));
        outline-color: var(--fallback-in, oklch(var(--in)/1))
    }

    .btn-success {
        --tw-text-opacity: 1;
        color: var(--fallback-suc, oklch(var(--suc)/var(--tw-text-opacity)));
        outline-color: var(--fallback-su, oklch(var(--su)/1))
    }

    .btn-error {
        --tw-text-opacity: 1;
        color: var(--fallback-erc, oklch(var(--erc)/var(--tw-text-opacity)));
        outline-color: var(--fallback-er, oklch(var(--er)/1))
    }

    .btn.glass {
        --tw-shadow: 0 0 #0000;
        --tw-shadow-colored: 0 0 #0000;
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
        outline-color: currentColor
    }

    .btn.glass.btn-active {
        --glass-opacity: 25%;
        --glass-border-opacity: 15%
    }

    .btn-ghost {
        border-width: 1px;
        border-color: transparent;
        background-color: transparent;
        color: currentColor;
        --tw-shadow: 0 0 #0000;
        --tw-shadow-colored: 0 0 #0000;
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
        outline-color: currentColor
    }

    .btn-ghost.btn-active {
        border-color: transparent;
        background-color: var(--fallback-bc, oklch(var(--bc)/.2))
    }

    .btn-link.btn-active {
        border-color: transparent;
        background-color: transparent;
        text-decoration-line: underline
    }

    .btn-outline {
        border-color: currentColor;
        background-color: transparent;
        --tw-text-opacity: 1;
        color: var(--fallback-bc, oklch(var(--bc)/var(--tw-text-opacity)));
        --tw-shadow: 0 0 #0000;
        --tw-shadow-colored: 0 0 #0000;
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
    }

    .btn-outline.btn-active {
        --tw-border-opacity: 1;
        border-color: var(--fallback-bc, oklch(var(--bc)/var(--tw-border-opacity)));
        --tw-bg-opacity: 1;
        background-color: var(--fallback-bc, oklch(var(--bc)/var(--tw-bg-opacity)));
        --tw-text-opacity: 1;
        color: var(--fallback-b1, oklch(var(--b1)/var(--tw-text-opacity)))
    }

    .btn-outline.btn-primary {
        --tw-text-opacity: 1;
        color: var(--fallback-p, oklch(var(--p)/var(--tw-text-opacity)))
    }

    .btn-outline.btn-primary.btn-active {
        --tw-text-opacity: 1;
        color: var(--fallback-pc, oklch(var(--pc)/var(--tw-text-opacity)))
    }

    .btn-outline.btn-secondary {
        --tw-text-opacity: 1;
        color: var(--fallback-s, oklch(var(--s)/var(--tw-text-opacity)))
    }

    .btn-outline.btn-secondary.btn-active {
        --tw-text-opacity: 1;
        color: var(--fallback-sc, oklch(var(--sc)/var(--tw-text-opacity)))
    }

    .btn-outline.btn-accent {
        --tw-text-opacity: 1;
        color: var(--fallback-a, oklch(var(--a)/var(--tw-text-opacity)))
    }

    .btn-outline.btn-accent.btn-active {
        --tw-text-opacity: 1;
        color: var(--fallback-ac, oklch(var(--ac)/var(--tw-text-opacity)))
    }

    .btn-outline.btn-success {
        --tw-text-opacity: 1;
        color: var(--fallback-su, oklch(var(--su)/var(--tw-text-opacity)))
    }

    .btn-outline.btn-success.btn-active {
        --tw-text-opacity: 1;
        color: var(--fallback-suc, oklch(var(--suc)/var(--tw-text-opacity)))
    }

    .btn-outline.btn-info {
        --tw-text-opacity: 1;
        color: var(--fallback-in, oklch(var(--in)/var(--tw-text-opacity)))
    }

    .btn-outline.btn-info.btn-active {
        --tw-text-opacity: 1;
        color: var(--fallback-inc, oklch(var(--inc)/var(--tw-text-opacity)))
    }

    .btn-outline.btn-warning {
        --tw-text-opacity: 1;
        color: var(--fallback-wa, oklch(var(--wa)/var(--tw-text-opacity)))
    }

    .btn-outline.btn-warning.btn-active {
        --tw-text-opacity: 1;
        color: var(--fallback-wac, oklch(var(--wac)/var(--tw-text-opacity)))
    }

    .btn-outline.btn-error {
        --tw-text-opacity: 1;
        color: var(--fallback-er, oklch(var(--er)/var(--tw-text-opacity)))
    }

    .btn-outline.btn-error.btn-active {
        --tw-text-opacity: 1;
        color: var(--fallback-erc, oklch(var(--erc)/var(--tw-text-opacity)))
    }

    .btn.btn-disabled,
    .btn[disabled],
    .btn:disabled {

        --tw-border-opacity: 0;
        background-color: var(--fallback-n, oklch(var(--n)/var(--tw-bg-opacity)));
        --tw-bg-opacity: .2;
        color: var(--fallback-bc, oklch(var(--bc)/var(--tw-text-opacity)));

        --tw-text-opacity: .2}.btn:is(input[type="checkbox"]:checked),
            .btn:is(input[type="radio"]:checked) {
            --tw-border-opacity: 1;
            border-color: var(--fallback-p, oklch(var(--p)/var(--tw-border-opacity)));
            --tw-bg-opacity: 1;
            background-color: var(--fallback-p, oklch(var(--p)/var(--tw-bg-opacity)));

            --tw-text-opacity: 1;color:var(--fallback-pc,oklch(var(--pc)/var(--tw-text-opacity)))}.btn:is(input[type="checkbox"]:checked):focus-visible, .btn:is(input[type="radio"]:checked):focus-visible {
                outline-color: var(--fallback-p, oklch(var(--p)/1))
            }

            @keyframes button-pop {
                0% {
                    transform: scale(var(--btn-focus-scale, .98))
                }

                40% {
                    transform: scale(1.02)
                }

                to {
                    transform: scale(1)
                }
            }

            .card.bordered {
                border-width: 1px;
                --tw-border-opacity: 1;
                border-color: var(--fallback-b2, oklch(var(--b2)/var(--tw-border-opacity)))
            }

            .checkbox:focus {
                box-shadow: none
            }

            .checkbox:focus-visible {
                outline-style: solid;
                outline-width: 2px;
                outline-offset: 2px;
                outline-color: var(--fallback-bc, oklch(var(--bc)/1))
            }

            .checkbox:disabled {
                border-width: 0px;
                cursor: not-allowed;
                border-color: transparent;
                --tw-bg-opacity: 1;
                background-color: var(--fallback-bc, oklch(var(--bc)/var(--tw-bg-opacity)));
                opacity: .2
            }

            .checkbox:checked,
            .checkbox[aria-checked=true] {
                background-repeat: no-repeat;
                animation: checkmark var(--animation-input, .2s) ease-out;
                background-color: var(--chkbg);
                background-image: linear-gradient(-45deg, transparent 65%, var(--chkbg) 65.99%), linear-gradient(45deg, transparent 75%, var(--chkbg) 75.99%), linear-gradient(-45deg, var(--chkbg) 40%, transparent 40.99%), linear-gradient(45deg, var(--chkbg) 30%, var(--chkfg) 30.99%, var(--chkfg) 40%, transparent 40.99%), linear-gradient(-45deg, var(--chkfg) 50%, var(--chkbg) 50.99%)
            }

            .checkbox:indeterminate {
                --tw-bg-opacity: 1;
                background-color: var(--fallback-bc, oklch(var(--bc)/var(--tw-bg-opacity)));
                background-repeat: no-repeat;
                animation: checkmark var(--animation-input, .2s) ease-out;
                background-image: linear-gradient(90deg, transparent 80%, var(--chkbg) 80%), linear-gradient(-90deg, transparent 80%, var(--chkbg) 80%), linear-gradient(0deg, var(--chkbg) 43%, var(--chkfg) 43%, var(--chkfg) 57%, var(--chkbg) 57%)
            }

            .checkbox-primary {
                --chkbg: var(--fallback-p, oklch(var(--p)/1));
                --chkfg: var(--fallback-pc, oklch(var(--pc)/1));
                --tw-border-opacity: 1;
                border-color: var(--fallback-p, oklch(var(--p)/var(--tw-border-opacity)))
            }

            .checkbox-primary:focus-visible {
                outline-color: var(--fallback-p, oklch(var(--p)/1))
            }

            .checkbox-primary:checked,
            .checkbox-primary[aria-checked=true] {
                --tw-border-opacity: 1;
                border-color: var(--fallback-p, oklch(var(--p)/var(--tw-border-opacity)));
                --tw-bg-opacity: 1;
                background-color: var(--fallback-p, oklch(var(--p)/var(--tw-bg-opacity)));
                --tw-text-opacity: 1;
                color: var(--fallback-pc, oklch(var(--pc)/var(--tw-text-opacity)))
            }

            .checkbox-info {
                --chkbg: var(--fallback-in, oklch(var(--in)/1));
                --chkfg: var(--fallback-inc, oklch(var(--inc)/1));
                --tw-border-opacity: 1;
                border-color: var(--fallback-in, oklch(var(--in)/var(--tw-border-opacity)))
            }

            .checkbox-info:focus-visible {
                outline-color: var(--fallback-in, oklch(var(--in)/1))
            }

            .checkbox-info:checked,
            .checkbox-info[aria-checked=true] {
                --tw-border-opacity: 1;
                border-color: var(--fallback-in, oklch(var(--in)/var(--tw-border-opacity)));
                --tw-bg-opacity: 1;
                background-color: var(--fallback-in, oklch(var(--in)/var(--tw-bg-opacity)));
                --tw-text-opacity: 1;
                color: var(--fallback-inc, oklch(var(--inc)/var(--tw-text-opacity)))
            }

            @keyframes checkmark {
                0% {
                    background-position-y: 5px
                }

                50% {
                    background-position-y: -2px
                }

                to {
                    background-position-y: 0
                }
            }

            details.collapse {
                width: 100%
            }

            details.collapse summary {
                position: relative;
                display: block;
                outline: 2px solid transparent;
                outline-offset: 2px
            }

            details.collapse summary::-webkit-details-marker {
                display: none
            }

            .collapse:focus-visible {
                outline-style: solid;
                outline-width: 2px;
                outline-offset: 2px;
                outline-color: var(--fallback-bc, oklch(var(--bc)/1))
            }

            .collapse:has(.collapse-title:focus-visible),
            .collapse:has(> input[type="checkbox"]:focus-visible),
            .collapse:has(> input[type="radio"]:focus-visible) {
                outline-style: solid;
                outline-width: 2px;
                outline-offset: 2px;
                outline-color: var(--fallback-bc, oklch(var(--bc)/1))
            }

            .collapse:not(.collapse-open):not(.collapse-close)>input[type=checkbox],
            .collapse:not(.collapse-open):not(.collapse-close)>input[type=radio]:not(:checked),
            .collapse:not(.collapse-open):not(.collapse-close)>.collapse-title {
                cursor: pointer
            }

            .collapse:focus:not(.collapse-open):not(.collapse-close):not(.collapse[open])>.collapse-title {
                cursor: unset
            }

            :where(.collapse > input[type="checkbox"]),
            :where(.collapse > input[type="radio"]) {
                z-index: 1
            }

            .collapse-title,
            :where(.collapse > input[type="checkbox"]),
            :where(.collapse > input[type="radio"]) {
                width: 100%;
                padding: 1rem;
                padding-inline-end: 3rem;
                min-height: 3.75rem;

                transition: background-color .2s ease-out}.collapse[open]>:where(.collapse-content),.collapse-open>:where(.collapse-content),.collapse:focus:not(.collapse-close)>:where(.collapse-content),.collapse:not(.collapse-close)>:where(input[type="checkbox"]:checked ~ .collapse-content),.collapse:not(.collapse-close)>:where(input[type="radio"]:checked ~ .collapse-content) {
                    padding-bottom: 1rem;
                    transition: padding .2s ease-out, background-color .2s ease-out
                }

                .collapse[open].collapse-arrow>.collapse-title:after,
                .collapse-open.collapse-arrow>.collapse-title:after,
                .collapse-arrow:focus:not(.collapse-close)>.collapse-title:after,
                .collapse-arrow:not(.collapse-close)>input[type=checkbox]:checked~.collapse-title:after,
                .collapse-arrow:not(.collapse-close)>input[type=radio]:checked~.collapse-title:after {
                    --tw-translate-y: -50%;
                    --tw-rotate: 225deg;
                    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
                }

                .collapse[open].collapse-plus>.collapse-title:after,
                .collapse-open.collapse-plus>.collapse-title:after,
                .collapse-plus:focus:not(.collapse-close)>.collapse-title:after,
                .collapse-plus:not(.collapse-close)>input[type=checkbox]:checked~.collapse-title:after,
                .collapse-plus:not(.collapse-close)>input[type=radio]:checked~.collapse-title:after {
                    content: "\2212"
                }

                .divider:not(:empty) {
                    gap: 1rem
                }

                .dropdown.dropdown-open .dropdown-content,
                .dropdown:focus .dropdown-content,
                .dropdown:focus-within .dropdown-content {
                    --tw-scale-x: 1;
                    --tw-scale-y: 1;
                    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
                }

                .file-input-bordered {
                    --tw-border-opacity: .2
                }

                .file-input:focus {
                    outline-style: solid;
                    outline-width: 2px;
                    outline-offset: 2px;
                    outline-color: var(--fallback-bc, oklch(var(--bc)/.2))
                }

                .file-input-error {
                    --tw-border-opacity: 1;
                    border-color: var(--fallback-er, oklch(var(--er)/var(--tw-border-opacity)))
                }

                .file-input-error:focus {
                    outline-color: var(--fallback-er, oklch(var(--er)/1))
                }

                .file-input-error::file-selector-button {
                    --tw-border-opacity: 1;
                    border-color: var(--fallback-er, oklch(var(--er)/var(--tw-border-opacity)));
                    --tw-bg-opacity: 1;
                    background-color: var(--fallback-er, oklch(var(--er)/var(--tw-bg-opacity)));
                    --tw-text-opacity: 1;
                    color: var(--fallback-erc, oklch(var(--erc)/var(--tw-text-opacity)))
                }

                .file-input-disabled,
                .file-input[disabled] {
                    cursor: not-allowed;
                    --tw-border-opacity: 1;
                    border-color: var(--fallback-b2, oklch(var(--b2)/var(--tw-border-opacity)));
                    --tw-bg-opacity: 1;
                    background-color: var(--fallback-b2, oklch(var(--b2)/var(--tw-bg-opacity)));
                    --tw-text-opacity: .2
                }

                .file-input-disabled::-moz-placeholder,
                .file-input[disabled]::-moz-placeholder {
                    color: var(--fallback-bc, oklch(var(--bc)/var(--tw-placeholder-opacity)));
                    --tw-placeholder-opacity: .2
                }

                .file-input-disabled::placeholder,
                .file-input[disabled]::placeholder {
                    color: var(--fallback-bc, oklch(var(--bc)/var(--tw-placeholder-opacity)));
                    --tw-placeholder-opacity: .2
                }

                .file-input-disabled::file-selector-button,
                .file-input[disabled]::file-selector-button {
                    --tw-border-opacity: 0;
                    background-color: var(--fallback-n, oklch(var(--n)/var(--tw-bg-opacity)));
                    --tw-bg-opacity: .2;
                    color: var(--fallback-bc, oklch(var(--bc)/var(--tw-text-opacity)));
                    --tw-text-opacity: .2
                }

                .label-text {
                    font-size: .875rem;
                    line-height: 1.25rem;
                    --tw-text-opacity: 1;
                    color: var(--fallback-bc, oklch(var(--bc)/var(--tw-text-opacity)))
                }

                .label-text-alt {
                    font-size: .75rem;
                    line-height: 1rem;
                    --tw-text-opacity: 1;
                    color: var(--fallback-bc, oklch(var(--bc)/var(--tw-text-opacity)))
                }

                .input input {
                    --tw-bg-opacity: 1;
                    background-color: var(--fallback-p, oklch(var(--p)/var(--tw-bg-opacity)));
                    background-color: transparent
                }

                .input input:focus {
                    outline: 2px solid transparent;
                    outline-offset: 2px
                }

                .input[list]::-webkit-calendar-picker-indicator {
                    line-height: 1em
                }

                .input-bordered {
                    border-color: var(--fallback-bc, oklch(var(--bc)/.2))
                }

                .input:focus,
                .input:focus-within {
                    box-shadow: none;
                    border-color: var(--fallback-bc, oklch(var(--bc)/.2));
                    outline-style: solid;
                    outline-width: 2px;
                    outline-offset: 2px;
                    outline-color: var(--fallback-bc, oklch(var(--bc)/.2))
                }

                .input-ghost {
                    --tw-bg-opacity: .05
                }

                .input-ghost:focus,
                .input-ghost:focus-within {
                    --tw-bg-opacity: 1;
                    --tw-text-opacity: 1;
                    color: var(--fallback-bc, oklch(var(--bc)/var(--tw-text-opacity)));
                    box-shadow: none
                }

                .input-error {
                    --tw-border-opacity: 1;
                    border-color: var(--fallback-er, oklch(var(--er)/var(--tw-border-opacity)))
                }

                .input-error:focus,
                .input-error:focus-within {
                    --tw-border-opacity: 1;
                    border-color: var(--fallback-er, oklch(var(--er)/var(--tw-border-opacity)));
                    outline-color: var(--fallback-er, oklch(var(--er)/1))
                }

                .input:has(> input[disabled]),
                .input-disabled,
                .input:disabled,
                .input[disabled] {
                    cursor: not-allowed;
                    --tw-border-opacity: 1;
                    border-color: var(--fallback-b2, oklch(var(--b2)/var(--tw-border-opacity)));
                    --tw-bg-opacity: 1;
                    background-color: var(--fallback-b2, oklch(var(--b2)/var(--tw-bg-opacity)));
                    color: var(--fallback-bc, oklch(var(--bc)/.4))
                }

                .input:has(> input[disabled])::-moz-placeholder,
                .input-disabled::-moz-placeholder,
                .input:disabled::-moz-placeholder,
                .input[disabled]::-moz-placeholder {
                    color: var(--fallback-bc, oklch(var(--bc)/var(--tw-placeholder-opacity)));
                    --tw-placeholder-opacity: .2
                }

                .input:has(> input[disabled])::placeholder,
                .input-disabled::placeholder,
                .input:disabled::placeholder,
                .input[disabled]::placeholder {
                    color: var(--fallback-bc, oklch(var(--bc)/var(--tw-placeholder-opacity)));
                    --tw-placeholder-opacity: .2
                }

                .input:has(> input[disabled])>input[disabled] {
                    cursor: not-allowed
                }

                .input::-webkit-date-and-time-value {
                    text-align: inherit
                }

                .join>:where(*:not(:first-child)) {
                    margin-top: 0;
                    margin-bottom: 0;
                    margin-inline-start: -1px
                }

                .join-item:focus {
                    isolation: isolate
                }

                .link-primary {
                    --tw-text-opacity: 1;
                    color: var(--fallback-p, oklch(var(--p)/var(--tw-text-opacity)))
                }

                @supports (color:color-mix(in oklab, black, black)) {
                    @media (hover:hover) {
                        .link-primary:hover {
                            color: color-mix(in oklab, var(--fallback-p, oklch(var(--p)/1)) 80%, black)
                        }
                    }
                }

                .link:focus {
                    outline: 2px solid transparent;
                    outline-offset: 2px
                }

                .link:focus-visible {
                    outline: 2px solid currentColor;
                    outline-offset: 2px
                }

                :where(.menu li:empty) {
                    --tw-bg-opacity: 1;
                    background-color: var(--fallback-bc, oklch(var(--bc)/var(--tw-bg-opacity)));
                    opacity: .1;
                    margin: .5rem 1rem;
                    height: 1px
                }

                .menu :where(li ul):before {
                    position: absolute;
                    bottom: .75rem;
                    inset-inline-start: 0px;
                    top: .75rem;
                    width: 1px;
                    --tw-bg-opacity: 1;
                    background-color: var(--fallback-bc, oklch(var(--bc)/var(--tw-bg-opacity)));
                    opacity: .1;
                    content: ""
                }

                .menu :where(li:not(.menu-title) > *:not(ul, details, .menu-title, .btn)),
                .menu :where(li:not(.menu-title) > details > summary:not(.menu-title)) {
                    border-radius: var(--rounded-btn, .5rem);
                    padding: .5rem 1rem;
                    text-align: start;
                    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, -webkit-backdrop-filter;
                    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
                    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter, -webkit-backdrop-filter;
                    transition-timing-function: cubic-bezier(.4, 0, .2, 1);
                    transition-timing-function: cubic-bezier(0, 0, .2, 1);
                    transition-duration: .2s;
                    text-wrap: balance
                }

                :where(.menu li:not(.menu-title, .disabled) > *:not(ul, details, .menu-title)):not(summary, .active, .btn).focus,
                :where(.menu li:not(.menu-title, .disabled) > *:not(ul, details, .menu-title)):not(summary, .active, .btn):focus,
                :where(.menu li:not(.menu-title, .disabled) > *:not(ul, details, .menu-title)):is(summary):not(.active, .btn):focus-visible,
                :where(.menu li:not(.menu-title, .disabled) > details > summary:not(.menu-title)):not(summary, .active, .btn).focus,
                :where(.menu li:not(.menu-title, .disabled) > details > summary:not(.menu-title)):not(summary, .active, .btn):focus,
                :where(.menu li:not(.menu-title, .disabled) > details > summary:not(.menu-title)):is(summary):not(.active, .btn):focus-visible {
                    cursor: pointer;
                    background-color: var(--fallback-bc, oklch(var(--bc)/.1));
                    --tw-text-opacity: 1;
                    color: var(--fallback-bc, oklch(var(--bc)/var(--tw-text-opacity)));
                    outline: 2px solid transparent;
                    outline-offset: 2px
                }

                .menu li>*:not(ul, .menu-title, details, .btn):active,
                .menu li>*:not(ul, .menu-title, details, .btn).active,
                .menu li>details>summary:active {
                    --tw-bg-opacity: 1;
                    background-color: var(--fallback-n, oklch(var(--n)/var(--tw-bg-opacity)));
                    --tw-text-opacity: 1;
                    color: var(--fallback-nc, oklch(var(--nc)/var(--tw-text-opacity)))
                }

                .menu :where(li > details > summary)::-webkit-details-marker {
                    display: none
                }

                .menu :where(li > details > summary):after,
                .menu :where(li > .menu-dropdown-toggle):after {
                    justify-self: end;
                    display: block;
                    margin-top: -.5rem;
                    height: .5rem;
                    width: .5rem;
                    transform: rotate(45deg);
                    transition-property: transform, margin-top;
                    transition-duration: .3s;
                    transition-timing-function: cubic-bezier(.4, 0, .2, 1);
                    content: "";
                    transform-origin: 75% 75%;
                    box-shadow: 2px 2px;
                    pointer-events: none
                }

                .menu :where(li > details[open] > summary):after,
                .menu :where(li > .menu-dropdown-toggle.menu-dropdown-show):after {
                    transform: rotate(225deg);
                    margin-top: 0
                }

                .mockup-browser .mockup-browser-toolbar .input {
                    position: relative;
                    margin-left: auto;
                    margin-right: auto;
                    display: block;
                    height: 1.75rem;
                    width: 24rem;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                    --tw-bg-opacity: 1;
                    background-color: var(--fallback-b2, oklch(var(--b2)/var(--tw-bg-opacity)));
                    padding-left: 2rem;
                    direction: ltr
                }

                .mockup-browser .mockup-browser-toolbar .input:before {
                    content: "";
                    position: absolute;
                    left: .5rem;
                    top: 50%;
                    aspect-ratio: 1 / 1;
                    height: .75rem;
                    --tw-translate-y: -50%;
                    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
                    border-radius: 9999px;
                    border-width: 2px;
                    border-color: currentColor;
                    opacity: .6
                }

                .mockup-browser .mockup-browser-toolbar .input:after {
                    content: "";
                    position: absolute;
                    left: 1.25rem;
                    top: 50%;
                    height: .5rem;
                    --tw-translate-y: 25%;
                    --tw-rotate: -45deg;
                    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
                    border-radius: 9999px;
                    border-width: 1px;
                    border-color: currentColor;
                    opacity: .6
                }

                .modal:not(dialog:not(.modal-open)),
                .modal::backdrop {
                    background-color: #0006;
                    animation: modal-pop .2s ease-out
                }

                .modal-backdrop {
                    z-index: -1;
                    grid-column-start: 1;
                    grid-row-start: 1;
                    display: grid;
                    align-self: stretch;
                    justify-self: stretch;
                    color: transparent
                }

                .modal-open .modal-box,
                .modal-toggle:checked+.modal .modal-box,
                .modal:target .modal-box,
                .modal[open] .modal-box {
                    --tw-translate-y: 0px;
                    --tw-scale-x: 1;
                    --tw-scale-y: 1;
                    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
                }

                @keyframes modal-pop {
                    0% {
                        opacity: 0
                    }
                }

                .progress::-moz-progress-bar {
                    border-radius: var(--rounded-box, 1rem);
                    --tw-bg-opacity: 1;
                    background-color: var(--fallback-bc, oklch(var(--bc)/var(--tw-bg-opacity)))
                }

                .progress-info::-moz-progress-bar {
                    border-radius: var(--rounded-box, 1rem);
                    --tw-bg-opacity: 1;
                    background-color: var(--fallback-in, oklch(var(--in)/var(--tw-bg-opacity)))
                }

                .progress:indeterminate {
                    --progress-color: var(--fallback-bc, oklch(var(--bc)/1));
                    background-image: repeating-linear-gradient(90deg, var(--progress-color) -1%, var(--progress-color) 10%, transparent 10%, transparent 90%);
                    background-size: 200%;
                    background-position-x: 15%;
                    animation: progress-loading 5s ease-in-out infinite
                }

                .progress-info:indeterminate {
                    --progress-color: var(--fallback-in, oklch(var(--in)/1))
                }

                .progress::-webkit-progress-bar {
                    border-radius: var(--rounded-box, 1rem);
                    background-color: transparent
                }

                .progress::-webkit-progress-value {
                    border-radius: var(--rounded-box, 1rem);
                    --tw-bg-opacity: 1;
                    background-color: var(--fallback-bc, oklch(var(--bc)/var(--tw-bg-opacity)))
                }

                .progress-info::-webkit-progress-value {
                    --tw-bg-opacity: 1;
                    background-color: var(--fallback-in, oklch(var(--in)/var(--tw-bg-opacity)))
                }

                .progress:indeterminate::-moz-progress-bar {
                    background-color: transparent;
                    background-image: repeating-linear-gradient(90deg, var(--progress-color) -1%, var(--progress-color) 10%, transparent 10%, transparent 90%);
                    background-size: 200%;
                    background-position-x: 15%;
                    animation: progress-loading 5s ease-in-out infinite
                }

                @keyframes progress-loading {
                    50% {
                        background-position-x: -115%
                    }
                }

                @keyframes radiomark {
                    0% {
                        box-shadow: 0 0 0 12px var(--fallback-b1, oklch(var(--b1)/1)) inset, 0 0 0 12px var(--fallback-b1, oklch(var(--b1)/1)) inset
                    }

                    50% {
                        box-shadow: 0 0 0 3px var(--fallback-b1, oklch(var(--b1)/1)) inset, 0 0 0 3px var(--fallback-b1, oklch(var(--b1)/1)) inset
                    }

                    to {
                        box-shadow: 0 0 0 4px var(--fallback-b1, oklch(var(--b1)/1)) inset, 0 0 0 4px var(--fallback-b1, oklch(var(--b1)/1)) inset
                    }
                }

                @keyframes rating-pop {
                    0% {
                        transform: translateY(-.125em)
                    }

                    40% {
                        transform: translateY(-.125em)
                    }

                    to {
                        transform: translateY(0)
                    }
                }

                .select-bordered {
                    border-color: var(--fallback-bc, oklch(var(--bc)/.2))
                }

                .select:focus {
                    box-shadow: none;
                    border-color: var(--fallback-bc, oklch(var(--bc)/.2));
                    outline-style: solid;
                    outline-width: 2px;
                    outline-offset: 2px;
                    outline-color: var(--fallback-bc, oklch(var(--bc)/.2))
                }

                .select-error {
                    --tw-border-opacity: 1;
                    border-color: var(--fallback-er, oklch(var(--er)/var(--tw-border-opacity)))
                }

                .select-error:focus {
                    --tw-border-opacity: 1;
                    border-color: var(--fallback-er, oklch(var(--er)/var(--tw-border-opacity)));
                    outline-color: var(--fallback-er, oklch(var(--er)/1))
                }

                .select-disabled,
                .select:disabled,
                .select[disabled] {
                    cursor: not-allowed;
                    --tw-border-opacity: 1;
                    border-color: var(--fallback-b2, oklch(var(--b2)/var(--tw-border-opacity)));
                    --tw-bg-opacity: 1;
                    background-color: var(--fallback-b2, oklch(var(--b2)/var(--tw-bg-opacity)));
                    color: var(--fallback-bc, oklch(var(--bc)/.4))
                }

                .select-disabled::-moz-placeholder,
                .select:disabled::-moz-placeholder,
                .select[disabled]::-moz-placeholder {
                    color: var(--fallback-bc, oklch(var(--bc)/var(--tw-placeholder-opacity)));
                    --tw-placeholder-opacity: .2
                }

                .select-disabled::placeholder,
                .select:disabled::placeholder,
                .select[disabled]::placeholder {
                    color: var(--fallback-bc, oklch(var(--bc)/var(--tw-placeholder-opacity)));

                    --tw-placeholder-opacity: .2}.select-multiple,.select[multiple],.select[size].select:not([size="1"]) {
                        background-image: none;
                        padding-right: 1rem
                    }

                    [dir=rtl] .select {
                        background-position: calc(0% + 12px) calc(1px + 50%), calc(0% + 16px) calc(1px + 50%)
                    }

                    @keyframes skeleton {
                        0% {
                            background-position: 150%
                        }

                        to {
                            background-position: -50%
                        }
                    }

                    .swap-rotate .swap-on,
                    .swap-rotate .swap-indeterminate,
                    .swap-rotate input:indeterminate~.swap-on {
                        --tw-rotate: 45deg;
                        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
                    }

                    .swap-rotate input:checked~.swap-off,
                    .swap-active:where(.swap-rotate) .swap-off,
                    .swap-rotate input:indeterminate~.swap-off {
                        --tw-rotate: -45deg;
                        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
                    }

                    .swap-rotate input:checked~.swap-on,
                    .swap-active:where(.swap-rotate) .swap-on,
                    .swap-rotate input:indeterminate~.swap-indeterminate {
                        --tw-rotate: 0deg;
                        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
                    }

                    .swap-flip .swap-on,
                    .swap-flip .swap-indeterminate,
                    .swap-flip input:indeterminate~.swap-on {
                        transform: rotateY(180deg);
                        backface-visibility: hidden;
                        opacity: 1
                    }

                    .swap-flip input:checked~.swap-off,
                    .swap-active:where(.swap-flip) .swap-off,
                    .swap-flip input:indeterminate~.swap-off {
                        transform: rotateY(-180deg);
                        backface-visibility: hidden;
                        opacity: 1
                    }

                    .swap-flip input:checked~.swap-on,
                    .swap-active:where(.swap-flip) .swap-on,
                    .swap-flip input:indeterminate~.swap-indeterminate{transform:rotateY(0)}.table:where([dir="rtl"],
                    [dir="rtl"] *) {
                        text-align: right
                    }

                    .table :where(th, td) {
                        padding: .75rem 1rem;
                        vertical-align: middle
                    }

                    .table tr.active,
                    .table tr.active:nth-child(even),
                    .table-zebra tbody tr:nth-child(even) {
                        --tw-bg-opacity: 1;
                        background-color: var(--fallback-b2, oklch(var(--b2)/var(--tw-bg-opacity)))
                    }

                    .table :where(thead tr, tbody tr:not(:last-child), tbody tr:first-child:last-child) {
                        border-bottom-width: 1px;
                        --tw-border-opacity: 1;
                        border-bottom-color: var(--fallback-b2, oklch(var(--b2)/var(--tw-border-opacity)))
                    }

                    .table :where(thead, tfoot) {
                        white-space: nowrap;
                        font-size: .75rem;
                        line-height: 1rem;
                        font-weight: 700;
                        color: var(--fallback-bc, oklch(var(--bc)/.6))
                    }

                    .table :where(tfoot) {
                        border-top-width: 1px;
                        --tw-border-opacity: 1;
                        border-top-color: var(--fallback-b2, oklch(var(--b2)/var(--tw-border-opacity)))
                    }

                    .textarea-bordered {
                        border-color: var(--fallback-bc, oklch(var(--bc)/.2))
                    }

                    .textarea:focus {
                        box-shadow: none;
                        border-color: var(--fallback-bc, oklch(var(--bc)/.2));
                        outline-style: solid;
                        outline-width: 2px;
                        outline-offset: 2px;
                        outline-color: var(--fallback-bc, oklch(var(--bc)/.2))
                    }

                    .textarea-error {
                        --tw-border-opacity: 1;
                        border-color: var(--fallback-er, oklch(var(--er)/var(--tw-border-opacity)))
                    }

                    .textarea-error:focus {
                        --tw-border-opacity: 1;
                        border-color: var(--fallback-er, oklch(var(--er)/var(--tw-border-opacity)));
                        outline-color: var(--fallback-er, oklch(var(--er)/1))
                    }

                    .textarea-disabled,
                    .textarea:disabled,
                    .textarea[disabled] {
                        cursor: not-allowed;
                        --tw-border-opacity: 1;
                        border-color: var(--fallback-b2, oklch(var(--b2)/var(--tw-border-opacity)));
                        --tw-bg-opacity: 1;
                        background-color: var(--fallback-b2, oklch(var(--b2)/var(--tw-bg-opacity)));
                        color: var(--fallback-bc, oklch(var(--bc)/.4))
                    }

                    .textarea-disabled::-moz-placeholder,
                    .textarea:disabled::-moz-placeholder,
                    .textarea[disabled]::-moz-placeholder {
                        color: var(--fallback-bc, oklch(var(--bc)/var(--tw-placeholder-opacity)));
                        --tw-placeholder-opacity: .2
                    }

                    .textarea-disabled::placeholder,
                    .textarea:disabled::placeholder,
                    .textarea[disabled]::placeholder {
                        color: var(--fallback-bc, oklch(var(--bc)/var(--tw-placeholder-opacity)));
                        --tw-placeholder-opacity: .2
                    }

                    .timeline hr {
                        height: .25rem
                    }

                    :where(.timeline hr) {
                        --tw-bg-opacity: 1;
                        background-color: var(--fallback-b3, oklch(var(--b3)/var(--tw-bg-opacity)))
                    }

                    :where(.timeline:has(.timeline-middle) hr):first-child {
                        border-start-end-radius: var(--rounded-badge, 1.9rem);
                        border-end-end-radius: var(--rounded-badge, 1.9rem);
                        border-start-start-radius: 0px;
                        border-end-start-radius: 0px
                    }

                    :where(.timeline:has(.timeline-middle) hr):last-child {
                        border-start-start-radius: var(--rounded-badge, 1.9rem);
                        border-end-start-radius: var(--rounded-badge, 1.9rem);
                        border-start-end-radius: 0px;
                        border-end-end-radius: 0px
                    }

                    :where(.timeline:not(:has(.timeline-middle)) :first-child hr:last-child) {
                        border-start-start-radius: var(--rounded-badge, 1.9rem);
                        border-end-start-radius: var(--rounded-badge, 1.9rem);
                        border-start-end-radius: 0px;
                        border-end-end-radius: 0px
                    }

                    :where(.timeline:not(:has(.timeline-middle)) :last-child hr:first-child) {
                        border-start-end-radius: var(--rounded-badge, 1.9rem);
                        border-end-end-radius: var(--rounded-badge, 1.9rem);
                        border-start-start-radius: 0px;
                        border-end-start-radius: 0px
                    }

                    @keyframes toast-pop {
                        0% {
                            transform: scale(.9);
                            opacity: 0
                        }

                        to {
                            transform: scale(1);
                            opacity: 1
                        }
                    }

                    [dir=rtl] .toggle {
                        --handleoffsetcalculator: calc(var(--handleoffset) * 1)
                    }

                    .toggle:focus-visible {
                        outline-style: solid;
                        outline-width: 2px;
                        outline-offset: 2px;
                        outline-color: var(--fallback-bc, oklch(var(--bc)/.2))
                    }

                    .toggle:hover {
                        background-color: currentColor
                    }

                    .toggle:checked,
                    .toggle[aria-checked=true] {
                        background-image: none;
                        --handleoffsetcalculator: var(--handleoffset);
                        --tw-text-opacity: 1;
                        color: var(--fallback-bc, oklch(var(--bc)/var(--tw-text-opacity)))
                    }

                    [dir=rtl] .toggle:checked,
                    [dir=rtl] .toggle[aria-checked=true] {
                        --handleoffsetcalculator: calc(var(--handleoffset) * -1)
                    }

                    .toggle:indeterminate {
                        --tw-text-opacity: 1;
                        color: var(--fallback-bc, oklch(var(--bc)/var(--tw-text-opacity)));
                        box-shadow: calc(var(--handleoffset) / 2) 0 0 2px var(--tglbg) inset, calc(var(--handleoffset) / -2) 0 0 2px var(--tglbg) inset, 0 0 0 2px var(--tglbg) inset
                    }

                    [dir=rtl] .toggle:indeterminate {
                        box-shadow: calc(var(--handleoffset) / 2) 0 0 2px var(--tglbg) inset, calc(var(--handleoffset) / -2) 0 0 2px var(--tglbg) inset, 0 0 0 2px var(--tglbg) inset
                    }

                    .toggle:disabled {
                        cursor: not-allowed;
                        --tw-border-opacity: 1;
                        border-color: var(--fallback-bc, oklch(var(--bc)/var(--tw-border-opacity)));
                        background-color: transparent;
                        opacity: .3;
                        --togglehandleborder: 0 0 0 3px var(--fallback-bc, oklch(var(--bc)/1)) inset, var(--handleoffsetcalculator) 0 0 3px var(--fallback-bc, oklch(var(--bc)/1)) inset
                    }

                    .glass,
                    .glass.btn-active {
                        border: none;
                        -webkit-backdrop-filter: blur(var(--glass-blur, 40px));
                        backdrop-filter: blur(var(--glass-blur, 40px));
                        background-color: transparent;
                        background-image: linear-gradient(135deg, rgb(255 255 255 / var(--glass-opacity, 30%)) 0%, rgb(0 0 0 / 0%) 100%), linear-gradient(var(--glass-reflex-degree, 100deg), rgb(255 255 255 / var(--glass-reflex-opacity, 10%)) 25%, rgb(0 0 0 / 0%) 25%);
                        box-shadow: 0 0 0 1px rgb(255 255 255 / var(--glass-border-opacity, 10%)) inset, 0 0 0 2px #0000000d;
                        text-shadow: 0 1px rgb(0 0 0 / var(--glass-text-shadow-opacity, 5%))
                    }

                    @media (hover: hover) {
                        .glass.btn-active {
                            border: none;
                            -webkit-backdrop-filter: blur(var(--glass-blur, 40px));
                            backdrop-filter: blur(var(--glass-blur, 40px));
                            background-color: transparent;
                            background-image: linear-gradient(135deg, rgb(255 255 255 / var(--glass-opacity, 30%)) 0%, rgb(0 0 0 / 0%) 100%), linear-gradient(var(--glass-reflex-degree, 100deg), rgb(255 255 255 / var(--glass-reflex-opacity, 10%)) 25%, rgb(0 0 0 / 0%) 25%);
                            box-shadow: 0 0 0 1px rgb(255 255 255 / var(--glass-border-opacity, 10%)) inset, 0 0 0 2px #0000000d;
                            text-shadow: 0 1px rgb(0 0 0 / var(--glass-text-shadow-opacity, 5%))
                        }
                    }

                    .btn-xs {
                        height: 1.5rem;
                        min-height: 1.5rem;
                        padding-left: .5rem;
                        padding-right: .5rem;
                        font-size: .75rem
                    }

                    .btn-sm {
                        height: 2rem;
                        min-height: 2rem;
                        padding-left: .75rem;
                        padding-right: .75rem;
                        font-size: .875rem
                    }

                    .btn-lg {
                        height: 4rem;
                        min-height: 4rem;
                        padding-left: 1.5rem;
                        padding-right: 1.5rem;
                        font-size: 1.125rem
                    }

                    .btn-block {
                        width: 100%
                    }

                    .btn-square:where(.btn-xs) {
                        height: 1.5rem;
                        width: 1.5rem;
                        padding: 0
                    }

                    .btn-square:where(.btn-sm) {
                        height: 2rem;
                        width: 2rem;
                        padding: 0
                    }

                    .btn-square:where(.btn-lg) {
                        height: 4rem;
                        width: 4rem;
                        padding: 0
                    }

                    .btn-circle:where(.btn-xs) {
                        height: 1.5rem;
                        width: 1.5rem;
                        border-radius: 9999px;
                        padding: 0
                    }

                    .btn-circle:where(.btn-sm) {
                        height: 2rem;
                        width: 2rem;
                        border-radius: 9999px;
                        padding: 0
                    }

                    .btn-circle:where(.btn-md) {
                        height: 3rem;
                        width: 3rem;
                        border-radius: 9999px;
                        padding: 0
                    }

                    .btn-circle:where(.btn-lg) {
                        height: 4rem;
                        width: 4rem;
                        border-radius: 9999px;
                        padding: 0
                    }

                    .file-input-sm {
                        height: 2rem;
                        padding-inline-end: .75rem;
                        font-size: .875rem;
                        line-height: 1.25rem;
                        line-height: 2
                    }

                    .file-input-sm::file-selector-button {
                        margin-right: .75rem;
                        font-size: .875rem
                    }

                    .indicator :where(.indicator-item) {
                        bottom: auto;
                        inset-inline-end: 0px;
                        inset-inline-start: auto;
                        top: 0px;
                        --tw-translate-y: -50%;
                        --tw-translate-x: 50%;
                        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
                    }

                    .indicator :where(.indicator-item):where([dir="rtl"], [dir="rtl"] *) {
                        --tw-translate-x: -50%;
                        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
                    }

                    .indicator :where(.indicator-item.indicator-start) {
                        inset-inline-end: auto;
                        inset-inline-start: 0px;
                        --tw-translate-x: -50%;
                        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
                    }

                    .indicator :where(.indicator-item.indicator-start):where([dir="rtl"], [dir="rtl"] *) {
                        --tw-translate-x: 50%;
                        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
                    }

                    .indicator :where(.indicator-item.indicator-center) {
                        inset-inline-end: 50%;
                        inset-inline-start: 50%;
                        --tw-translate-x: -50%;
                        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
                    }

                    .indicator :where(.indicator-item.indicator-center):where([dir="rtl"], [dir="rtl"] *) {
                        --tw-translate-x: 50%;
                        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
                    }

                    .indicator :where(.indicator-item.indicator-end) {
                        inset-inline-end: 0px;
                        inset-inline-start: auto;
                        --tw-translate-x: 50%;
                        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
                    }

                    .indicator :where(.indicator-item.indicator-end):where([dir="rtl"], [dir="rtl"] *) {
                        --tw-translate-x: -50%;
                        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
                    }

                    .indicator :where(.indicator-item.indicator-bottom) {
                        bottom: 0px;
                        top: auto;
                        --tw-translate-y: 50%;
                        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
                    }

                    .indicator :where(.indicator-item.indicator-middle) {
                        bottom: 50%;
                        top: 50%;
                        --tw-translate-y: -50%;
                        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
                    }

                    .indicator :where(.indicator-item.indicator-top) {
                        bottom: auto;
                        top: 0px;
                        --tw-translate-y: -50%;
                        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
                    }

                    .input-sm {
                        height: 2rem;
                        padding-left: .75rem;
                        padding-right: .75rem;
                        font-size: .875rem;
                        line-height: 2rem
                    }

                    .join.join-vertical {
                        flex-direction: column
                    }

                    .join.join-vertical .join-item:first-child:not(:last-child),
                    .join.join-vertical *:first-child:not(:last-child) .join-item {
                        border-end-start-radius: 0;
                        border-end-end-radius: 0;
                        border-start-start-radius: inherit;
                        border-start-end-radius: inherit
                    }

                    .join.join-vertical .join-item:last-child:not(:first-child),
                    .join.join-vertical *:last-child:not(:first-child) .join-item {
                        border-start-start-radius: 0;
                        border-start-end-radius: 0;
                        border-end-start-radius: inherit;
                        border-end-end-radius: inherit
                    }

                    .join.join-horizontal {
                        flex-direction: row
                    }

                    .join.join-horizontal .join-item:first-child:not(:last-child),
                    .join.join-horizontal *:first-child:not(:last-child) .join-item {
                        border-end-end-radius: 0;
                        border-start-end-radius: 0;
                        border-end-start-radius: inherit;
                        border-start-start-radius: inherit
                    }

                    .join.join-horizontal .join-item:last-child:not(:first-child),
                    .join.join-horizontal *:last-child:not(:first-child) .join-item {
                        border-end-start-radius: 0;
                        border-start-start-radius: 0;
                        border-end-end-radius: inherit;
                        border-start-end-radius: inherit
                    }

                    .select-sm {
                        height: 2rem;
                        min-height: 2rem;
                        padding-left: .75rem;
                        padding-right: 2rem;
                        font-size: .875rem;
                        line-height: 2rem
                    }

                    [dir=rtl] .select-sm {
                        padding-left: 2rem;
                        padding-right: .75rem
                    }

                    .textarea-sm {
                        padding: .25rem .75rem;
                        font-size: .875rem;
                        line-height: 2rem
                    }

                    .timeline-vertical {
                        flex-direction: column
                    }

                    .timeline-compact,
                    .timeline-horizontal.timeline-compact {
                        --timeline-row-start: 0
                    }

                    .timeline-compact .timeline-start,
                    .timeline-horizontal.timeline-compact .timeline-start {
                        grid-column-start: 1;
                        grid-column-end: 4;
                        grid-row-start: 3;
                        grid-row-end: 4;
                        margin: .25rem;
                        align-self: flex-start;
                        justify-self: center
                    }

                    .timeline-compact li:has(.timeline-start) .timeline-end,
                    .timeline-horizontal.timeline-compact li:has(.timeline-start) .timeline-end {
                        grid-column-start: none;
                        grid-row-start: auto
                    }

                    .timeline-vertical.timeline-compact>li {
                        --timeline-col-start: 0
                    }

                    .timeline-vertical.timeline-compact .timeline-start {
                        grid-column-start: 3;
                        grid-column-end: 4;
                        grid-row-start: 1;
                        grid-row-end: 4;
                        align-self: center;
                        justify-self: start
                    }

                    .timeline-vertical.timeline-compact li:has(.timeline-start) .timeline-end {
                        grid-column-start: auto;
                        grid-row-start: none
                    }

                    :where(.timeline-vertical > li) {
                        --timeline-row-start: minmax(0, 1fr);
                        --timeline-row-end: minmax(0, 1fr);
                        justify-items: center
                    }

                    .timeline-vertical>li>hr {
                        height: 100%
                    }

                    :where(.timeline-vertical > li > hr):first-child {
                        grid-column-start: 2;
                        grid-row-start: 1
                    }

                    :where(.timeline-vertical > li > hr):last-child {
                        grid-column-start: 2;
                        grid-column-end: auto;
                        grid-row-start: 3;
                        grid-row-end: none
                    }

                    .timeline-vertical .timeline-start {
                        grid-column-start: 1;
                        grid-column-end: 2;
                        grid-row-start: 1;
                        grid-row-end: 4;
                        align-self: center;
                        justify-self: end
                    }

                    .timeline-vertical .timeline-end {
                        grid-column-start: 3;
                        grid-column-end: 4;
                        grid-row-start: 1;
                        grid-row-end: 4;
                        align-self: center;
                        justify-self: start
                    }

                    .timeline-vertical:where(.timeline-snap-icon)>li {
                        --timeline-col-start: minmax(0, 1fr);
                        --timeline-row-start: .5rem
                    }

                    .timeline-horizontal .timeline-end {
                        grid-column-start: 1;
                        grid-column-end: 4;
                        grid-row-start: 3;
                        grid-row-end: 4;
                        align-self: flex-start;
                        justify-self: center
                    }

                    :where(.timeline-snap-icon)>li,
                    .timeline-horizontal:where(.timeline-snap-icon)>li {
                        --timeline-col-start: .5rem;
                        --timeline-row-start: minmax(0, 1fr)
                    }

                    .tooltip {
                        position: relative;
                        display: inline-block;
                        --tooltip-offset: calc(100% + 1px + var(--tooltip-tail, 0px))
                    }

                    .tooltip:before {
                        position: absolute;
                        pointer-events: none;
                        z-index: 1;
                        content: var(--tw-content);
                        --tw-content: attr(data-tip)
                    }

                    .tooltip:before,
                    .tooltip-top:before {
                        transform: translate(-50%);
                        top: auto;
                        left: 50%;
                        right: auto;
                        bottom: var(--tooltip-offset)
                    }

                    .avatar.online:before {
                        content: "";
                        position: absolute;
                        z-index: 10;
                        display: block;
                        border-radius: 9999px;
                        --tw-bg-opacity: 1;
                        background-color: var(--fallback-su, oklch(var(--su)/var(--tw-bg-opacity)));
                        outline-style: solid;
                        outline-width: 2px;
                        outline-color: var(--fallback-b1, oklch(var(--b1)/1));
                        width: 15%;
                        height: 15%;
                        top: 7%;
                        right: 7%
                    }

                    .avatar.offline:before {
                        content: "";
                        position: absolute;
                        z-index: 10;
                        display: block;
                        border-radius: 9999px;
                        --tw-bg-opacity: 1;
                        background-color: var(--fallback-b3, oklch(var(--b3)/var(--tw-bg-opacity)));
                        outline-style: solid;
                        outline-width: 2px;
                        outline-color: var(--fallback-b1, oklch(var(--b1)/1));
                        width: 15%;
                        height: 15%;
                        top: 7%;
                        right: 7%
                    }

                    .join.join-vertical>:where(*:not(:first-child)) {
                        margin-left: 0;
                        margin-right: 0;
                        margin-top: -1px
                    }

                    .join.join-horizontal>:where(*:not(:first-child)) {
                        margin-top: 0;
                        margin-bottom: 0;
                        margin-inline-start: -1px
                    }

                    .menu-sm :where(li:not(.menu-title) > *:not(ul, details, .menu-title)),
                    .menu-sm :where(li:not(.menu-title) > details > summary:not(.menu-title)) {
                        border-radius: var(--rounded-btn, .5rem);
                        padding: .25rem .75rem;
                        font-size: .875rem;
                        line-height: 1.25rem
                    }

                    .menu-sm .menu-title {
                        padding: .5rem .75rem
                    }

                    .modal-top :where(.modal-box) {
                        width: 100%;
                        max-width: none;
                        --tw-translate-y: -2.5rem;
                        --tw-scale-x: 1;
                        --tw-scale-y: 1;
                        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
                        border-bottom-right-radius: var(--rounded-box, 1rem);
                        border-bottom-left-radius: var(--rounded-box, 1rem);
                        border-top-left-radius: 0;
                        border-top-right-radius: 0
                    }

                    .modal-middle :where(.modal-box) {
                        width: 91.666667%;
                        max-width: 32rem;
                        --tw-translate-y: 0px;
                        --tw-scale-x: .9;
                        --tw-scale-y: .9;
                        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
                        border-top-left-radius: var(--rounded-box, 1rem);
                        border-top-right-radius: var(--rounded-box, 1rem);
                        border-bottom-right-radius: var(--rounded-box, 1rem);
                        border-bottom-left-radius: var(--rounded-box, 1rem)
                    }

                    .modal-bottom :where(.modal-box) {
                        width: 100%;
                        max-width: none;
                        --tw-translate-y: 2.5rem;
                        --tw-scale-x: 1;
                        --tw-scale-y: 1;
                        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
                        border-top-left-radius: var(--rounded-box, 1rem);
                        border-top-right-radius: var(--rounded-box, 1rem);
                        border-bottom-right-radius: 0;
                        border-bottom-left-radius: 0
                    }

                    .table-sm :not(thead):not(tfoot) tr {
                        font-size: .875rem;
                        line-height: 1.25rem
                    }

                    .table-sm :where(th, td) {
                        padding: .5rem .75rem
                    }

                    .timeline-vertical>li>hr {
                        width: .25rem
                    }

                    :where(.timeline-vertical:has(.timeline-middle) > li > hr):first-child {
                        border-bottom-right-radius: var(--rounded-badge, 1.9rem);
                        border-bottom-left-radius: var(--rounded-badge, 1.9rem);
                        border-top-left-radius: 0;
                        border-top-right-radius: 0
                    }

                    :where(.timeline-vertical:has(.timeline-middle) > li > hr):last-child {
                        border-top-left-radius: var(--rounded-badge, 1.9rem);
                        border-top-right-radius: var(--rounded-badge, 1.9rem);
                        border-bottom-right-radius: 0;
                        border-bottom-left-radius: 0
                    }

                    :where(.timeline-vertical:not(:has(.timeline-middle)) :first-child > hr:last-child) {
                        border-top-left-radius: var(--rounded-badge, 1.9rem);
                        border-top-right-radius: var(--rounded-badge, 1.9rem);
                        border-bottom-right-radius: 0;
                        border-bottom-left-radius: 0
                    }

                    :where(.timeline-vertical:not(:has(.timeline-middle)) :last-child > hr:first-child) {
                        border-bottom-right-radius: var(--rounded-badge, 1.9rem);
                        border-bottom-left-radius: var(--rounded-badge, 1.9rem);
                        border-top-left-radius: 0;
                        border-top-right-radius: 0
                    }

                    :where(.timeline-horizontal:has(.timeline-middle) > li > hr):first-child {
                        border-start-end-radius: var(--rounded-badge, 1.9rem);
                        border-end-end-radius: var(--rounded-badge, 1.9rem);
                        border-start-start-radius: 0px;
                        border-end-start-radius: 0px
                    }

                    :where(.timeline-horizontal:has(.timeline-middle) > li > hr):last-child {
                        border-start-start-radius: var(--rounded-badge, 1.9rem);
                        border-end-start-radius: var(--rounded-badge, 1.9rem);
                        border-start-end-radius: 0px;
                        border-end-end-radius: 0px
                    }

                    .tooltip {
                        position: relative;
                        display: inline-block;
                        text-align: center;
                        --tooltip-tail: .1875rem;
                        --tooltip-color: var(--fallback-n, oklch(var(--n)/1));
                        --tooltip-text-color: var(--fallback-nc, oklch(var(--nc)/1));
                        --tooltip-tail-offset: calc(100% + .0625rem - var(--tooltip-tail))
                    }

                    .tooltip:before,
                    .tooltip:after {
                        opacity: 0;
                        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, -webkit-backdrop-filter;
                        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
                        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter, -webkit-backdrop-filter;
                        transition-delay: .1s;
                        transition-duration: .2s;
                        transition-timing-function: cubic-bezier(.4, 0, .2, 1)
                    }

                    .tooltip:after {
                        position: absolute;
                        content: "";
                        border-style: solid;
                        border-width: var(--tooltip-tail, 0);
                        width: 0;
                        height: 0;
                        display: block
                    }

                    .tooltip:before {
                        max-width: 20rem;
                        white-space: normal;
                        border-radius: .25rem;
                        padding: .25rem .5rem;
                        font-size: .875rem;
                        line-height: 1.25rem;
                        background-color: var(--tooltip-color);
                        color: var(--tooltip-text-color);
                        width: -moz-max-content;
                        width: max-content
                    }

                    .tooltip.tooltip-open:before {
                        opacity: 1;
                        transition-delay: 75ms
                    }

                    .tooltip.tooltip-open:after {
                        opacity: 1;
                        transition-delay: 75ms
                    }

                    .tooltip:hover:before {
                        opacity: 1;
                        transition-delay: 75ms
                    }

                    .tooltip:hover:after {
                        opacity: 1;
                        transition-delay: 75ms
                    }

                    .tooltip:has(:focus-visible):after,
                    .tooltip:has(:focus-visible):before {
                        opacity: 1;
                        transition-delay: 75ms
                    }

                    .tooltip:not([data-tip]):hover:before,
                    .tooltip:not([data-tip]):hover:after {
                        visibility: hidden;
                        opacity: 0
                    }

                    .tooltip:after,
                    .tooltip-top:after {
                        transform: translate(-50%);
                        border-color: var(--tooltip-color) transparent transparent transparent;
                        top: auto;
                        left: 50%;
                        right: auto;
                        bottom: var(--tooltip-tail-offset)
                    }

                    .collapse {
                        visibility: collapse
                    }

                    .static {
                        position: static
                    }

                    .fixed {
                        position: fixed
                    }

                    .absolute {
                        position: absolute
                    }

                    .relative {
                        position: relative
                    }

                    .sticky {
                        position: sticky
                    }

                    .inset-0 {
                        inset: 0px
                    }

                    .left-0 {
                        left: 0px
                    }

                    .right-0 {
                        right: 0px
                    }

                    .right-2 {
                        right: .5rem
                    }

                    .right-4 {
                        right: 1rem
                    }

                    .top-0 {
                        top: 0px
                    }

                    .top-2 {
                        top: .5rem
                    }

                    .top-4 {
                        top: 1rem
                    }

                    .z-0 {
                        z-index: 0
                    }

                    .z-10 {
                        z-index: 10
                    }

                    .z-20 {
                        z-index: 20
                    }

                    .z-50 {
                        z-index: 50
                    }

                    .z-\[1\] {
                        z-index: 1
                    }

                    .order-1 {
                        order: 1
                    }

                    .order-2 {
                        order: 2
                    }

                    .order-3 {
                        order: 3
                    }

                    .col-span-4 {
                        grid-column: span 4 / span 4
                    }

                    .col-start-1 {
                        grid-column-start: 1
                    }

                    .col-start-2 {
                        grid-column-start: 2
                    }

                    .row-span-2 {
                        grid-row: span 2 / span 2
                    }

                    .row-span-3 {
                        grid-row: span 3 / span 3
                    }

                    .row-start-1 {
                        grid-row-start: 1
                    }

                    .row-start-3 {
                        grid-row-start: 3
                    }

                    .m-1 {
                        margin: .25rem
                    }

                    .mx-auto {
                        margin-left: auto;
                        margin-right: auto
                    }

                    .-ml-px {
                        margin-left: -1px
                    }

                    .mb-1 {
                        margin-bottom: .25rem
                    }

                    .mb-10 {
                        margin-bottom: 2.5rem
                    }

                    .mb-2 {
                        margin-bottom: .5rem
                    }

                    .mb-3 {
                        margin-bottom: .75rem
                    }

                    .mb-4 {
                        margin-bottom: 1rem
                    }

                    .ml-1 {
                        margin-left: .25rem
                    }

                    .ml-2 {
                        margin-left: .5rem
                    }

                    .ml-3 {
                        margin-left: .75rem
                    }

                    .mr-1 {
                        margin-right: .25rem
                    }

                    .mt-1 {
                        margin-top: .25rem
                    }

                    .mt-3 {
                        margin-top: .75rem
                    }

                    .mt-4 {
                        margin-top: 1rem
                    }

                    .flex {
                        display: flex
                    }

                    .inline-flex {
                        display: inline-flex
                    }

                    .table {
                        display: table
                    }

                    .grid {
                        display: grid
                    }

                    .hidden {
                        display: none
                    }

                    .aspect-square {
                        aspect-ratio: 1 / 1
                    }

                    .h-5 {
                        height: 1.25rem
                    }

                    .h-6 {
                        height: 1.5rem
                    }

                    .h-full {
                        height: 100%
                    }

                    .h-screen {
                        height: 100vh
                    }

                    .max-h-full {
                        max-height: 100%
                    }

                    .w-10 {
                        width: 2.5rem
                    }

                    .w-11\/12 {
                        width: 91.666667%
                    }

                    .w-24 {
                        width: 6rem
                    }

                    .w-5 {
                        width: 1.25rem
                    }

                    .w-52 {
                        width: 13rem
                    }

                    .w-6 {
                        width: 1.5rem
                    }

                    .w-64 {
                        width: 16rem
                    }

                    .w-full {
                        width: 100%
                    }

                    .min-w-full {
                        min-width: 100%
                    }

                    .max-w-2xl {
                        max-width: 42rem
                    }

                    .max-w-3xl {
                        max-width: 48rem
                    }

                    .max-w-5xl {
                        max-width: 64rem
                    }

                    .max-w-7xl {
                        max-width: 80rem
                    }

                    .max-w-full {
                        max-width: 100%
                    }

                    .max-w-md {
                        max-width: 28rem
                    }

                    .max-w-xl {
                        max-width: 36rem
                    }

                    .max-w-xs {
                        max-width: 20rem
                    }

                    .flex-1 {
                        flex: 1 1 0%
                    }

                    .flex-none {
                        flex: none
                    }

                    .shrink {
                        flex-shrink: 1
                    }

                    .shrink-0 {
                        flex-shrink: 0
                    }

                    .grow {
                        flex-grow: 1
                    }

                    .basis-64 {
                        flex-basis: 16rem
                    }

                    .border-collapse {
                        border-collapse: collapse
                    }

                    .-translate-x-full {
                        --tw-translate-x: -100%;
                        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
                    }

                    .translate-x-full {
                        --tw-translate-x: 100%;
                        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
                    }

                    .cursor-default {
                        cursor: default
                    }

                    .cursor-pointer {
                        cursor: pointer
                    }

                    .grid-cols-1 {
                        grid-template-columns: repeat(1, minmax(0, 1fr))
                    }

                    .grid-cols-5 {
                        grid-template-columns: repeat(5, minmax(0, 1fr))
                    }

                    .grid-rows-3 {
                        grid-template-rows: repeat(3, minmax(0, 1fr))
                    }

                    .grid-rows-\[1fr_auto\] {
                        grid-template-rows: 1fr auto
                    }

                    .grid-rows-\[auto_1fr\] {
                        grid-template-rows: auto 1fr
                    }

                    .grid-rows-\[auto_auto_1fr\] {
                        grid-template-rows: auto auto 1fr
                    }

                    .flex-col {
                        flex-direction: column
                    }

                    .flex-wrap {
                        flex-wrap: wrap
                    }

                    .items-center {
                        align-items: center
                    }

                    .justify-end {
                        justify-content: flex-end
                    }

                    .justify-center {
                        justify-content: center
                    }

                    .justify-between {
                        justify-content: space-between
                    }

                    .gap-1 {
                        gap: .25rem
                    }

                    .gap-2 {
                        gap: .5rem
                    }

                    .gap-4 {
                        gap: 1rem
                    }

                    .overflow-hidden {
                        overflow: hidden
                    }

                    .overflow-x-auto {
                        overflow-x: auto
                    }

                    .overflow-y-auto {
                        overflow-y: auto
                    }

                    .overflow-x-hidden {
                        overflow-x: hidden
                    }

                    .overflow-y-hidden {
                        overflow-y: hidden
                    }

                    .whitespace-normal {
                        white-space: normal
                    }

                    .whitespace-nowrap {
                        white-space: nowrap
                    }

                    .rounded {
                        border-radius: .25rem
                    }

                    .rounded-box {
                        border-radius: var(--rounded-box, 1rem)
                    }

                    .rounded-full {
                        border-radius: 9999px
                    }

                    .rounded-lg {
                        border-radius: .5rem
                    }

                    .rounded-md {
                        border-radius: .375rem
                    }

                    .rounded-l-md {
                        border-top-left-radius: .375rem;
                        border-bottom-left-radius: .375rem
                    }

                    .rounded-r-md {
                        border-top-right-radius: .375rem;
                        border-bottom-right-radius: .375rem
                    }

                    .border {
                        border-width: 1px
                    }

                    .border-0 {
                        border-width: 0px
                    }

                    .border-x {
                        border-left-width: 1px;
                        border-right-width: 1px
                    }

                    .border-b {
                        border-bottom-width: 1px
                    }

                    .border-t {
                        border-top-width: 1px
                    }

                    .border-dashed {
                        border-style: dashed
                    }

                    .border-base-content {
                        --tw-border-opacity: 1;
                        border-color: var(--fallback-bc, oklch(var(--bc)/var(--tw-border-opacity)))
                    }

                    .border-base-content\/20 {
                        border-color: var(--fallback-bc, oklch(var(--bc)/.2))
                    }

                    .border-gray-300 {
                        --tw-border-opacity: 1;
                        border-color: rgb(209 213 219 / var(--tw-border-opacity))
                    }

                    .border-primary-content {
                        --tw-border-opacity: 1;
                        border-color: var(--fallback-pc, oklch(var(--pc)/var(--tw-border-opacity)))
                    }

                    .bg-accent {
                        --tw-bg-opacity: 1;
                        background-color: var(--fallback-a, oklch(var(--a)/var(--tw-bg-opacity)))
                    }

                    .bg-base-100 {
                        --tw-bg-opacity: 1;
                        background-color: var(--fallback-b1, oklch(var(--b1)/var(--tw-bg-opacity)))
                    }

                    .bg-base-200 {
                        --tw-bg-opacity: 1;
                        background-color: var(--fallback-b2, oklch(var(--b2)/var(--tw-bg-opacity)))
                    }

                    .bg-base-300 {
                        --tw-bg-opacity: 1;
                        background-color: var(--fallback-b3, oklch(var(--b3)/var(--tw-bg-opacity)))
                    }

                    .bg-neutral {
                        --tw-bg-opacity: 1;
                        background-color: var(--fallback-n, oklch(var(--n)/var(--tw-bg-opacity)))
                    }

                    .bg-primary {
                        --tw-bg-opacity: 1;
                        background-color: var(--fallback-p, oklch(var(--p)/var(--tw-bg-opacity)))
                    }

                    .bg-secondary {
                        --tw-bg-opacity: 1;
                        background-color: var(--fallback-s, oklch(var(--s)/var(--tw-bg-opacity)))
                    }

                    .bg-white {
                        --tw-bg-opacity: 1;
                        background-color: rgb(255 255 255 / var(--tw-bg-opacity))
                    }

                    .fill-base-content {
                        fill: var(--fallback-bc, oklch(var(--bc)/1))
                    }

                    .fill-neutral-content {
                        fill: var(--fallback-nc, oklch(var(--nc)/1))
                    }

                    .stroke-current {
                        stroke: currentColor
                    }

                    .p-0 {
                        padding: 0
                    }

                    .p-2 {
                        padding: .5rem
                    }

                    .p-4 {
                        padding: 1rem
                    }

                    .px-1 {
                        padding-left: .25rem;
                        padding-right: .25rem
                    }

                    .px-2 {
                        padding-left: .5rem;
                        padding-right: .5rem
                    }

                    .px-4 {
                        padding-left: 1rem;
                        padding-right: 1rem
                    }

                    .py-2 {
                        padding-top: .5rem;
                        padding-bottom: .5rem
                    }

                    .pb-0 {
                        padding-bottom: 0
                    }

                    .pb-2 {
                        padding-bottom: .5rem
                    }

                    .pb-6 {
                        padding-bottom: 1.5rem
                    }

                    .pr-0 {
                        padding-right: 0
                    }

                    .pt-0 {
                        padding-top: 0
                    }

                    .pt-3 {
                        padding-top: .75rem
                    }

                    .text-center {
                        text-align: center
                    }

                    .text-right {
                        text-align: right
                    }

                    .text-justify {
                        text-align: justify
                    }

                    .text-start {
                        text-align: start
                    }

                    .text-end {
                        text-align: end
                    }

                    .align-top {
                        vertical-align: top
                    }

                    .align-middle {
                        vertical-align: middle
                    }

                    .font-mono {
                        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, Liberation Mono, Courier New, monospace
                    }

                    .font-sans {
                        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", Segoe UI Symbol, "Noto Color Emoji"
                    }

                    .text-3xl {
                        font-size: 1.875rem;
                        line-height: 2.25rem
                    }

                    .text-lg {
                        font-size: 1.125rem;
                        line-height: 1.75rem
                    }

                    .text-sm {
                        font-size: .875rem;
                        line-height: 1.25rem
                    }

                    .text-xl {
                        font-size: 1.25rem;
                        line-height: 1.75rem
                    }

                    .font-black {
                        font-weight: 900
                    }

                    .font-bold {
                        font-weight: 700
                    }

                    .font-medium {
                        font-weight: 500
                    }

                    .normal-case {
                        text-transform: none
                    }

                    .italic {
                        font-style: italic
                    }

                    .leading-5 {
                        line-height: 1.25rem
                    }

                    .text-accent-content {
                        --tw-text-opacity: 1;
                        color: var(--fallback-ac, oklch(var(--ac)/var(--tw-text-opacity)))
                    }

                    .text-base-content {
                        --tw-text-opacity: 1;
                        color: var(--fallback-bc, oklch(var(--bc)/var(--tw-text-opacity)))
                    }

                    .text-error {
                        --tw-text-opacity: 1;
                        color: var(--fallback-er, oklch(var(--er)/var(--tw-text-opacity)))
                    }

                    .text-gray-500 {
                        --tw-text-opacity: 1;
                        color: rgb(107 114 128 / var(--tw-text-opacity))
                    }

                    .text-gray-700 {
                        --tw-text-opacity: 1;
                        color: rgb(55 65 81 / var(--tw-text-opacity))
                    }

                    .text-neutral-content {
                        --tw-text-opacity: 1;
                        color: var(--fallback-nc, oklch(var(--nc)/var(--tw-text-opacity)))
                    }

                    .text-primary {
                        --tw-text-opacity: 1;
                        color: var(--fallback-p, oklch(var(--p)/var(--tw-text-opacity)))
                    }

                    .text-primary-content {
                        --tw-text-opacity: 1;
                        color: var(--fallback-pc, oklch(var(--pc)/var(--tw-text-opacity)))
                    }

                    .text-red-500 {
                        --tw-text-opacity: 1;
                        color: rgb(239 68 68 / var(--tw-text-opacity))
                    }

                    .text-secondary-content {
                        --tw-text-opacity: 1;
                        color: var(--fallback-sc, oklch(var(--sc)/var(--tw-text-opacity)))
                    }

                    .text-success {
                        --tw-text-opacity: 1;
                        color: var(--fallback-su, oklch(var(--su)/var(--tw-text-opacity)))
                    }

                    .\!shadow-none {
                        --tw-shadow: 0 0 #0000 !important;
                        --tw-shadow-colored: 0 0 #0000 !important;
                        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow) !important
                    }

                    .shadow {
                        --tw-shadow: 0 1px 3px 0 rgb(0 0 0 / .1), 0 1px 2px -1px rgb(0 0 0 / .1);
                        --tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);
                        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
                    }

                    .shadow-sm {
                        --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / .05);
                        --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color);
                        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
                    }

                    .shadow-base-content {
                        --tw-shadow-color: var(--fallback-bc, oklch(var(--bc)/1));
                        --tw-shadow: var(--tw-shadow-colored)
                    }

                    .outline-none {
                        outline: 2px solid transparent;
                        outline-offset: 2px
                    }

                    .outline {
                        outline-style: solid
                    }

                    .outline-2 {
                        outline-width: 2px
                    }

                    .outline-offset-2 {
                        outline-offset: 2px
                    }

                    .\!outline-base-content {
                        outline-color: var(--fallback-bc, oklch(var(--bc)/1)) !important
                    }

                    .outline-transparent {
                        outline-color: transparent
                    }

                    .ring-0 {
                        --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
                        --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(0px + var(--tw-ring-offset-width)) var(--tw-ring-color);
                        box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)
                    }

                    .ring-gray-300 {
                        --tw-ring-opacity: 1;
                        --tw-ring-color: rgb(209 213 219 / var(--tw-ring-opacity))
                    }

                    .filter {
                        filter: var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)
                    }

                    .transition {
                        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, -webkit-backdrop-filter;
                        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
                        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter, -webkit-backdrop-filter;
                        transition-timing-function: cubic-bezier(.4, 0, .2, 1);
                        transition-duration: .15s
                    }

                    .transition-colors {
                        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
                        transition-timing-function: cubic-bezier(.4, 0, .2, 1);
                        transition-duration: .15s
                    }

                    .duration-150 {
                        transition-duration: .15s
                    }

                    .duration-200 {
                        transition-duration: .2s
                    }

                    .ease-in-out {
                        transition-timing-function: cubic-bezier(.4, 0, .2, 1)
                    }

                    ol {
                        margin-left: 1rem;
                        list-style-position: inside;
                        list-style-type: decimal
                    }

                    ul {
                        margin-left: 1rem;
                        list-style-position: inside;
                        list-style-type: disc
                    }

                    blockquote {
                        border-left-width: 4px;
                        --tw-border-opacity: 1;
                        border-color: var(--fallback-p, oklch(var(--p)/var(--tw-border-opacity)));
                        padding-left: 1rem
                    }

                    pre {
                        border-radius: var(--rounded-box, 1rem);
                        --tw-bg-opacity: 1;
                        background-color: var(--fallback-b2, oklch(var(--b2)/var(--tw-bg-opacity)));
                        padding: 1rem;
                        --tw-text-opacity: 1;
                        color: var(--fallback-bc, oklch(var(--bc)/var(--tw-text-opacity)))
                    }

                    @media (min-width: 1024px) {
                        .lg\:dropdown-end .dropdown-content {
                            inset-inline-end: 0px
                        }

                        .lg\:dropdown-end.dropdown-right .dropdown-content,
                        .lg\:dropdown-end.dropdown-left .dropdown-content {
                            bottom: 0px;
                            top: auto
                        }
                    }

                    .before\:absolute:before {
                        content: var(--tw-content);
                        position: absolute
                    }

                    .before\:left-0:before {
                        content: var(--tw-content);
                        left: 0px
                    }

                    .before\:top-0:before {
                        content: var(--tw-content);
                        top: 0px
                    }

                    .before\:block:before {
                        content: var(--tw-content);
                        display: block
                    }

                    .before\:h-\[1px\]:before {
                        content: var(--tw-content);
                        height: 1px
                    }

                    .before\:w-full:before {
                        content: var(--tw-content);
                        width: 100%
                    }

                    .before\:bg-neutral-content:before {
                        content: var(--tw-content);
                        --tw-bg-opacity: 1;
                        background-color: var(--fallback-nc, oklch(var(--nc)/var(--tw-bg-opacity)))
                    }

                    .before\:content-\[\'\'\]:before {
                        --tw-content: "";
                        content: var(--tw-content)
                    }

                    .after\:absolute:after {
                        content: var(--tw-content);
                        position: absolute
                    }

                    .after\:bottom-0:after {
                        content: var(--tw-content);
                        bottom: 0px
                    }

                    .after\:left-0:after {
                        content: var(--tw-content);
                        left: 0px
                    }

                    .after\:block:after {
                        content: var(--tw-content);
                        display: block
                    }

                    .after\:h-\[1px\]:after {
                        content: var(--tw-content);
                        height: 1px
                    }

                    .after\:w-full:after {
                        content: var(--tw-content);
                        width: 100%
                    }

                    .after\:bg-neutral-content:after {
                        content: var(--tw-content);
                        --tw-bg-opacity: 1;
                        background-color: var(--fallback-nc, oklch(var(--nc)/var(--tw-bg-opacity)))
                    }

                    .after\:content-\[\'\'\]:after {
                        --tw-content: "";
                        content: var(--tw-content)
                    }

                    .focus-within\:border-indigo-500:focus-within {
                        --tw-border-opacity: 1;
                        border-color: rgb(99 102 241 / var(--tw-border-opacity))
                    }

                    .focus-within\:ring-1:focus-within {
                        --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
                        --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);
                        box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)
                    }

                    .focus-within\:ring-indigo-500:focus-within {
                        --tw-ring-opacity: 1;
                        --tw-ring-color: rgb(99 102 241 / var(--tw-ring-opacity))
                    }

                    .hover\:border-base-content\/40:hover {
                        border-color: var(--fallback-bc, oklch(var(--bc)/.4))
                    }

                    .hover\:text-gray-400:hover {
                        --tw-text-opacity: 1;
                        color: rgb(156 163 175 / var(--tw-text-opacity))
                    }

                    .hover\:text-gray-500:hover {
                        --tw-text-opacity: 1;
                        color: rgb(107 114 128 / var(--tw-text-opacity))
                    }

                    .focus\:z-10:focus {
                        z-index: 10
                    }

                    .focus\:border-blue-300:focus {
                        --tw-border-opacity: 1;
                        border-color: rgb(147 197 253 / var(--tw-border-opacity))
                    }

                    .focus\:outline-none:focus {
                        outline: 2px solid transparent;
                        outline-offset: 2px
                    }

                    .focus\:ring:focus {
                        --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
                        --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(3px + var(--tw-ring-offset-width)) var(--tw-ring-color);
                        box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)
                    }

                    .active\:bg-gray-100:active {
                        --tw-bg-opacity: 1;
                        background-color: rgb(243 244 246 / var(--tw-bg-opacity))
                    }

                    .active\:text-gray-500:active {
                        --tw-text-opacity: 1;
                        color: rgb(107 114 128 / var(--tw-text-opacity))
                    }

                    .active\:text-gray-700:active {
                        --tw-text-opacity: 1;
                        color: rgb(55 65 81 / var(--tw-text-opacity))
                    }

                    @media (min-width: 640px) {
                        .sm\:flex {
                            display: flex
                        }

                        .sm\:hidden {
                            display: none
                        }

                        .sm\:flex-1 {
                            flex: 1 1 0%
                        }

                        .sm\:items-center {
                            align-items: center
                        }

                        .sm\:justify-center {
                            justify-content: center
                        }
                    }

                    @media (min-width: 768px) {
                        .md\:flex-row {
                            flex-direction: row
                        }
                    }

                    @media (min-width: 1024px) {
                        .lg\:order-1 {
                            order: 1
                        }

                        .lg\:order-2 {
                            order: 2
                        }

                        .lg\:block {
                            display: block
                        }

                        .lg\:flex {
                            display: flex
                        }

                        .lg\:hidden {
                            display: none
                        }

                        .lg\:max-h-full {
                            max-height: 100%
                        }

                        .lg\:w-6 {
                            width: 1.5rem
                        }

                        .lg\:basis-4\/12 {
                            flex-basis: 33.333333%
                        }

                        .lg\:basis-5\/12 {
                            flex-basis: 41.666667%
                        }

                        .lg\:basis-7\/12 {
                            flex-basis: 58.333333%
                        }

                        .lg\:basis-8\/12 {
                            flex-basis: 66.666667%
                        }

                        .lg\:flex-row {
                            flex-direction: row
                        }

                        .lg\:flex-col {
                            flex-direction: column
                        }

                        .lg\:justify-start {
                            justify-content: flex-start
                        }

                        .lg\:px-0 {
                            padding-left: 0;
                            padding-right: 0
                        }
                    }

                    .\[\&_trix-toolbar\]\:sticky trix-toolbar {
                        position: sticky
                    }

                    .\[\&_trix-toolbar\]\:top-0 trix-toolbar {
                        top: 0px
                    }

                    .\[\&_trix-toolbar\]\:z-10 trix-toolbar {
                        z-index: 10
                    }

                    .\[\&_trix-toolbar\]\:-mx-2 trix-toolbar {
                        margin-left: -.5rem;
                        margin-right: -.5rem
                    }

                    .\[\&_trix-toolbar\]\:rounded-t-lg trix-toolbar {
                        border-top-left-radius: .5rem;
                        border-top-right-radius: .5rem
                    }

                    .\[\&_trix-toolbar\]\:border-b trix-toolbar {
                        border-bottom-width: 1px
                    }

                    .\[\&_trix-toolbar\]\:bg-white trix-toolbar {
                        --tw-bg-opacity: 1;
                        background-color: rgb(255 255 255 / var(--tw-bg-opacity))
                    }

                    .\[\&_trix-toolbar\]\:px-2 trix-toolbar {
                        padding-left: .5rem;
                        padding-right: .5rem
                    }

                    .\[\&_trix-toolbar\]\:pt-2 trix-toolbar {
                        padding-top: .5rem
                    }

                    .\[\&_trix-toolbar\]\:shadow-sm trix-toolbar {
                        --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / .05);
                        --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color);
                        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
                    }
</style>

<page backtop="5mm" backbottom="10mm" backleft="5mm" backright="5mm">
    <page_header>
        <table class="page_header" cellspacing="0px" cellpadding="0px">

        </table>
    </page_header>
    <page_footer>
        <div style="padding: 1mm; font-size: 9px">
            Generated by Monev ALIKA | {{ Carbon\Carbon::now() }}
        </div>
    </page_footer>
    <table class="collapse" style="table-layout:fixed; width: 330mm; font-size: 18px; white-space: break-spaces; padding: 5mm 0">
        <tr>
            <td style="width: 330mm" class="text-center">
                REKAP ARSIP TAGIHAN
            </td>
        </tr>
    </table>
    <table class="collapse" style="table-layout:fixed; width: 330mm; font-size: 9px; white-space: break-spaces">
        <tr class="text-center">
            <th rowspan="2" class="border" style="padding: 1mm; width: 7mm">No</th>
            <th rowspan="2" class="border" style="padding: 1mm; width: 12mm">Jenis Tagihan</th>
            <th rowspan="2" class="border" style="padding: 1mm; width: 12mm">Nomor</th>
            <th rowspan="2" class="border" style="padding: 1mm; width: 12mm">Tanggal</th>
            <th rowspan="2" class="border" style="padding: 1mm; width: 42mm">Uraian</th>
            <th rowspan="2" class="border" style="padding: 1mm; width: 32mm">Unit</th>
            <th rowspan="2" class="border" style="padding: 1mm; width: 27mm">PPK</th>
            <th rowspan="2" class="border" style="padding: 1mm; width: 27mm">Bruto</th>
            <th colspan="3" class="border" style="padding:1mm">Dokumen</th>
        </tr>
        <tr class="text-center">
            <th class="border" style="padding: 1mm; width: 27mm">Jenis Dokumen</th>
            <th class="border" style="padding: 1mm; width: 42mm">Keterangan</th>
            <th class="border" style="padding: 1mm; width: 17mm">Link</th>
        </tr>
        @foreach ($data as $item)
            <tr style="page-break-after: always">
                <td class="border text-center" style="padding: 1mm; width: 7mm">{{ $loop->iteration }}</td>
                <td class="border text-center" style="padding: 1mm; width: 12mm">
                    @switch($item->jnstagihan)
                        @case('0')
                            SPBy
                        @break

                        @case('1')
                            SPP
                        @break

                        @case('2')
                            KKP
                        @break
                    @endswitch
                </td>
                <td class="border text-center" style="padding: 1mm; width: 12mm">{{ $item->notagihan }}</td>
                <td class="border" style="padding: 1mm; width: 12mm">{{ $item->tgltagihan }}</td>
                <td class="border" style="padding: 1mm; width: 42mm">{{ $item->uraian }}</td>
                <td class="border" style="padding: 1mm; width: 32mm">{{ optional($item->unit)->namaunit }}</td>
                <td class="border" style="padding: 1mm; width: 27mm">{{ optional($item->ppk)->nama }}</td>
                <td class="border text-right" style="padding: 1mm; width: 27mm">
                    {{ number_format($item->realisasi->sum('realisasi'), 2, ',', '.') }}</td>
                <td class="border" style="padding: 1mm; width: 27mm">
                    {{ optional(optional($item->berkasUpload->first())->berkas)->namaberkas }}</td>
                <td class="border" style="padding: 1mm; width: 42mm">
                    {{ optional($item->berkasUpload->first())->uraian }}</td>
                <td class="border text-center" style="padding: 1mm; width: 18mm">
                    @if ($item->berkasUpload->first())
                        <a href="{{ env('APP_URL') }}/file-view/{{ optional($item->berkasUpload->first())->file }}"
                            class="btn btn-xs btn-outline btn-neutral" target="_blank">download</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</page>
