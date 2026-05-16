<script setup>
import { ref, onMounted, defineEmits, defineProps } from "vue";
import gsap from "gsap";

const props = defineProps({
    isFirstLoad: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(["reveal", "complete"]);
const loaderRef = ref(null);
const curtainTop = ref(null);
const curtainBottom = ref(null);
const portalRef = ref(null);
const contentRef = ref(null);

const text1 = "DESA PARDOMUAN".split("");
const text2 = "AJIBATA".split("");

onMounted(() => {
    const runCurtainOnly = () => {
        const openTl = gsap.timeline({
            onComplete: () => emit("complete"),
        });

        emit("reveal");

        openTl.to([curtainTop.value, curtainBottom.value], {
            yPercent: (i) => (i === 0 ? -100 : 100),
            duration: 1,
            ease: "expo.inOut",
        });

        openTl.to(
            loaderRef.value,
            {
                opacity: 0,
                duration: 0.8,
                ease: "none",
            },
            0.5,
        );
    };

    const runFullIntro = () => {
        const tl = gsap.timeline({
            onComplete: () => {
                gsap.delayedCall(0.5, () => {
                    const openTl = gsap.timeline({
                        onComplete: () => emit("complete"),
                    });

                    emit("reveal");

                    openTl.to(
                        contentRef.value,
                        {
                            scale: 1.5,
                            opacity: 0,
                            duration: 1,
                            ease: "power2.inOut",
                        },
                        0,
                    );

                    openTl.to(
                        portalRef.value,
                        {
                            scale: 8,
                            opacity: 0,
                            duration: 1.2,
                            ease: "expo.inOut",
                        },
                        0,
                    );

                    openTl.to(
                        [curtainTop.value, curtainBottom.value],
                        {
                            yPercent: (i) => (i === 0 ? -100 : 100),
                            duration: 1.2,
                            ease: "expo.inOut",
                        },
                        0.2,
                    );

                    openTl.to(
                        loaderRef.value,
                        {
                            opacity: 0,
                            duration: 1,
                            ease: "none",
                        },
                        0.5,
                    );
                });
            },
        });

        tl.addLabel("textStart");
        tl.fromTo(
            ".letter-1",
            { y: 15, opacity: 0, filter: "blur(8px)" },
            {
                y: 0,
                opacity: 1,
                filter: "blur(0px)",
                duration: 0.4,
                stagger: 0.05,
                ease: "power3.out",
            },
            "textStart",
        );
        tl.fromTo(
            ".letter-2",
            { y: 15, opacity: 0, filter: "blur(8px)" },
            {
                y: 0,
                opacity: 1,
                filter: "blur(0px)",
                duration: 0.4,
                stagger: 0.05,
                ease: "power3.out",
            },
            "textStart+=0.15",
        );

        tl.addLabel("bloom");
        tl.fromTo(
            portalRef.value,
            { scale: 0.2, opacity: 0 },
            { scale: 1, opacity: 1, duration: 0.6, ease: "power3.out" },
            "bloom-=0.2",
        );
        tl.fromTo(
            ".ray",
            { scaleX: 0, opacity: 0 },
            {
                scaleX: 1,
                opacity: 0.5,
                duration: 0.4,
                stagger: 0.03,
                ease: "power4.out",
            },
            "bloom",
        );

        gsap.to(".rays-wrap", {
            rotation: 360,
            duration: 25,
            repeat: -1,
            ease: "none",
        });
    };

    if (props.isFirstLoad) {
        runFullIntro();
    } else {
        runCurtainOnly();
    }
});
</script>

<template>
    <div class="intro-experience" ref="loaderRef">
        <div class="curtain top" ref="curtainTop">
            <div class="noise"></div>
        </div>
        <div class="curtain bottom" ref="curtainBottom">
            <div class="noise"></div>
        </div>

        <template v-if="isFirstLoad">
            <div class="portal-container">
                <div class="portal-glow" ref="portalRef"></div>
                <div class="rays-wrap">
                    <div
                        v-for="n in 12"
                        :key="n"
                        class="ray"
                        :style="{ transform: `rotate(${n * 30}deg)` }"
                    ></div>
                </div>
            </div>

            <div class="intro-content" ref="contentRef">
                <div class="title-wrap">
                    <p class="tagline">WARISAN LELUHUR</p>
                    <h1 class="brand-name">
                        <div class="word">
                            <span
                                v-for="(l, i) in text1"
                                :key="i"
                                class="letter letter-1"
                            >
                                {{ l === " " ? "\u00A0" : l }}
                            </span>
                        </div>
                        <span class="text-dot letter-2">●</span>
                        <div class="word">
                            <span
                                v-for="(l, i) in text2"
                                :key="i"
                                class="letter letter-2"
                            >
                                {{ l === " " ? "\u00A0" : l }}
                            </span>
                        </div>
                    </h1>
                </div>
            </div>

            <div class="particles">
                <div
                    v-for="n in 15"
                    :key="n"
                    class="particle"
                    :style="{
                        top: Math.random() * 100 + '%',
                        left: Math.random() * 100 + '%',
                        animationDuration: 8 + Math.random() * 10 + 's',
                    }"
                ></div>
            </div>
        </template>
    </div>
</template>

<style scoped>
.intro-experience {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: transparent;
}

.curtain {
    position: absolute;
    left: 0;
    width: 100%;
    height: 50.5%;
    background: #080a09;
    z-index: 1;
}

.curtain.top {
    top: 0;
}
.curtain.bottom {
    bottom: 0;
}

.noise {
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
    opacity: 0.04;
}

.portal-container {
    position: absolute;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
}

.portal-glow {
    width: 400px;
    height: 400px;
    background: radial-gradient(
        circle,
        rgba(116, 198, 157, 0.4) 0%,
        rgba(45, 106, 79, 0.15) 30%,
        rgba(26, 61, 43, 0.05) 50%,
        transparent 70%
    );
}

.ray {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 500px;
    height: 2px;
    background: linear-gradient(
        90deg,
        rgba(116, 198, 157, 0.3) 0%,
        transparent 80%
    );
    transform-origin: left center;
}

.intro-content {
    position: relative;
    z-index: 10;
    text-align: center;
    color: #f9f7f4;
}

.tagline {
    font-size: 0.7rem;
    letter-spacing: 0.6em;
    color: var(--green-light);
    margin-bottom: 1.5rem;
    opacity: 0.7;
}

.brand-name {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    font-family: "Lora", serif;
    font-size: clamp(1.5rem, 6vw, 4rem);
    font-weight: 700;
    margin: 0;
}

.word {
    display: flex;
}

.letter {
    display: inline-block;
    will-change: transform, opacity;
}

.letter-2:not(.text-dot) {
    color: var(--green-light);
    font-style: italic;
}

.text-dot {
    color: var(--green-light);
    font-size: 0.5em;
    opacity: 0.6;
}

.particles {
    position: absolute;
    inset: 0;
    z-index: 2;
}

.particle {
    position: absolute;
    width: 2px;
    height: 2px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    animation: float infinite linear;
}

@keyframes float {
    from {
        transform: translateY(0);
        opacity: 0;
    }
    50% {
        opacity: 0.3;
    }
    to {
        transform: translateY(-100px);
        opacity: 0;
    }
}

@media (max-width: 768px) {
    .brand-name {
        font-size: 2.5rem;
        gap: 0.8rem;
    }
}
</style>
