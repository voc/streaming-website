const createElement = (tag, props = {}, ...children) => {
	const el = document.createElement(tag);
	for (const [k, v] of Object.entries(props)) {
		if (k.startsWith("on") && typeof v === "function")
			el.addEventListener(k.slice(2).toLowerCase(), v);
		else if (k === "style" || k === "dataset") Object.assign(el[k], v);
		else if (k in el) el[k] = v;              // className, value, checked…
		else el.setAttribute(k, v);               // aria-*, custom attrs
	}
	el.append(...children.flat(Infinity).filter(c => c != null && c !== false));
	return el;
};

const randomBetween = (min, max) => min + Math.random() * (max - min);

const BUBBLE_COUNT = 14;

const randomizeBubble = (bubble, lane) => {
	const size = randomBetween(16, 88);
	Object.assign(bubble.style, {
		// each bubble stays in its own horizontal lane, so they rarely bump into each other
		left: `${(lane + randomBetween(0.1, 0.9)) * (100 / BUBBLE_COUNT)}vw`,
		width: `${size}px`,
		height: `${size}px`,
		opacity: randomBetween(0.15, 0.25).toFixed(2),
	});
};

const createBubble = (_, lane) => {
	const duration = randomBetween(30, 70);
	// seed the first pass anywhere from "still waiting below" (positive delay) up to
	// halfway into the viewport (negative delay); later passes always enter from below
	const delay = randomBetween(-0.5, 0.5) * duration;
	const bubble = createElement("div", {
		style: {
			position: "absolute",
			top: "100vh",
			animation: `bubble-rise ${duration}s linear ${delay}s infinite`,
		},
		// each rise loop ends above the viewport; re-roll before it wraps back to the bottom
		// (the inner sway animation's iteration events bubble up here too, hence the filter)
		onanimationiteration: (e) => {
			if (e.animationName === "bubble-rise") randomizeBubble(bubble, lane);
		},
	},
		createElement("div", {
			style: {
				width: "100%",
				height: "100%",
				"border-radius": "9999px",
				background: "linear-gradient(0deg, #d7e8c2ff, #b4ee99ff)",
				animation: `bubble-sway ${randomBetween(3, 8)}s ease-in-out ${-randomBetween(0, 8)}s infinite alternate`,
			},
		}),
	);
	randomizeBubble(bubble, lane);
	return bubble;
};

document.head.append(createElement("style", {},
	"@keyframes bubble-rise { to { transform: translateY(calc(-100vh - 100%)); } }",
	"@keyframes bubble-sway { from { transform: translateX(-12px); } to { transform: translateX(12px); } }",
	// !important, because the inline animation shorthand resets play-state to running
	".bubbles-paused * { animation-play-state: paused !important; }",
));

// fixed overflow-hidden layer, so the below-viewport bubbles don't grow the page
const bubbleLayer = createElement("div", {
	style: {
		position: "fixed",
		inset: "0",
		overflow: "hidden",
		"z-index": "-1",
		"pointer-events": "none",
	},
}, Array.from({ length: BUBBLE_COUNT }, createBubble));
document.body.append(bubbleLayer);

// under reduced motion the bubbles stay visible, just frozen in place
const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");
const applyMotionPreference = () => {
	bubbleLayer.classList.toggle("bubbles-paused", reducedMotion.matches);
};
applyMotionPreference();
reducedMotion.addEventListener("change", applyMotionPreference);
