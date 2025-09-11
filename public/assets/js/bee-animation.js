// Full page flying bee animation on a fixed overlay canvas
// Opacity is controlled via CSS on the canvas element
(function(){
	const canvas = document.getElementById('bee-canvas');
	if(!canvas) return;
	const ctx = canvas.getContext('2d');

	let w = window.innerWidth;
	let h = window.innerHeight;
	const DPR = Math.min(window.devicePixelRatio || 1, 2);

	function resize(){
		w = window.innerWidth; h = window.innerHeight;
		canvas.width = Math.floor(w * DPR);
		canvas.height = Math.floor(h * DPR);
		canvas.style.width = w + 'px';
		canvas.style.height = h + 'px';
		ctx.setTransform(DPR,0,0,DPR,0,0);
	}
	window.addEventListener('resize', resize);
	resize();

	// Bee params
	const SCALE = 1.7; // increase to make the bee larger
	const trail = [];
	const TRAIL_MAX = 120;
	let t = 0;

	// Fireworks params
	const bursts = [];
	let imageRect = null;
	let insideImage = false;

	function updateImageRect(){
		const el = document.getElementById('profile-svg');
		if(!el){ imageRect = null; return; }
		const r = el.getBoundingClientRect();
		imageRect = { x: r.left, y: r.top, w: r.width, h: r.height };
	}
	window.addEventListener('resize', updateImageRect);
	window.addEventListener('scroll', updateImageRect, { passive: true });
	updateImageRect();

	function spawnBurst(cx, cy){
		const colors = ['#00ffa0','#44ddff','#88ff55','#22cc88','#bbffdd','#66aaff','#ccffee'];
		const count = 90; // bigger burst
		const particles = [];
		for(let i=0;i<count;i++){
			const a = Math.random()*Math.PI*2;
			const sp = 3 + Math.random()*6; // faster spread
			particles.push({
				x: cx,
				y: cy,
				vx: Math.cos(a)*sp,
				vy: Math.sin(a)*sp - Math.random()*0.5,
				size: 3 + Math.random()*3.5, // larger particles
				life: 100 + Math.random()*60, // longer life
				color: colors[(Math.random()*colors.length)|0]
			});
		}
		// Add a faint shockwave ring for scale
		bursts.push({ particles, ring: { r: 0, max: 140, alpha: 0.45 } });
	}

	function pathPos(time){
		// Lissajous-like curve that covers the whole page
		const ax = w*0.45, ay = h*0.35;
		const x = w/2 + ax*Math.sin(time*0.7) + (w*0.18)*Math.sin(time*1.7);
		const y = h/2 + ay*Math.sin(time*0.9 + Math.PI/3) + (h*0.12)*Math.sin(time*1.3);
		return {x,y};
	}

	function drawBee(x,y,angle){
		ctx.save();
		ctx.translate(x,y);
		ctx.rotate(angle);

		// body (scaled)
		ctx.fillStyle = '#222';
		ctx.beginPath();
		ctx.ellipse(0,0,18*SCALE,11*SCALE,0,0,Math.PI*2);
		ctx.fill();
		ctx.fillStyle = '#ffd100';
		ctx.beginPath();
		ctx.ellipse(-3*SCALE,0,14*SCALE,9*SCALE,0,0,Math.PI*2);
		ctx.fill();
		// stripes
		ctx.fillStyle = '#000';
		ctx.fillRect(-9*SCALE,-8*SCALE,3*SCALE,16*SCALE);
		ctx.fillRect(-2*SCALE,-8*SCALE,3*SCALE,16*SCALE);

		// head
		ctx.fillStyle = '#111';
		ctx.beginPath();
		ctx.arc(15*SCALE,0,7*SCALE,0,Math.PI*2);
		ctx.fill();

		// wings
		const wingAlpha = 0.35 + 0.25*Math.sin(t*24);
		ctx.fillStyle = 'rgba(180,240,255,'+wingAlpha.toFixed(3)+')';
		ctx.beginPath();
		ctx.ellipse(2*SCALE,-12*SCALE,14*SCALE,9*SCALE,0,0,Math.PI*2);
		ctx.fill();
		ctx.beginPath();
		ctx.ellipse(2*SCALE,12*SCALE,14*SCALE,9*SCALE,0,0,Math.PI*2);
		ctx.fill();

		ctx.restore();
	}

	function draw(){
		// Clear frame completely to avoid haze/darkening
		ctx.globalCompositeOperation = 'source-over';
		ctx.clearRect(0,0,w,h);

		const p = pathPos(t);
		trail.push({x:p.x,y:p.y});
		if(trail.length>TRAIL_MAX) trail.shift();

		// Detect if bee is behind the profile image
		if(imageRect){
			const inside = (p.x>=imageRect.x && p.x<=imageRect.x+imageRect.w && p.y>=imageRect.y && p.y<=imageRect.y+imageRect.h);
			if(!insideImage && inside){
				// trigger burst slightly inside the image area
				spawnBurst(p.x, p.y);
			}
			insideImage = inside;
		}

		// draw trail
		ctx.globalCompositeOperation = 'lighter';
		for(let i=0;i<trail.length;i++){
			const a = i/trail.length;
			const c = Math.floor(200*a+40);
			ctx.fillStyle = 'rgba(0,'+c+',80,'+(0.06+0.25*a).toFixed(3)+')';
			ctx.beginPath();
			ctx.arc(trail[i].x, trail[i].y, Math.max(1,7*a), 0, Math.PI*2);
			ctx.fill();
		}

		// draw fireworks bursts behind image (same canvas is under content)
		ctx.globalCompositeOperation = 'lighter';
		for(let b=bursts.length-1;b>=0;b--){
			const burst = bursts[b];
			for(let i=burst.particles.length-1;i>=0;i--){
				const pa = burst.particles[i];
				pa.x += pa.vx; pa.y += pa.vy; pa.vy += 0.03; // gravity
				pa.life -= 1;
				ctx.fillStyle = pa.color.replace('#','') ? pa.color : '#ffffff';
				const alpha = Math.max(0, Math.min(1, pa.life/60));
				ctx.fillStyle = `rgba(${parseInt(pa.color.slice(1,3),16)},${parseInt(pa.color.slice(3,5),16)},${parseInt(pa.color.slice(5,7),16)},${alpha})`;
				ctx.beginPath();
				ctx.arc(pa.x, pa.y, pa.size, 0, Math.PI*2);
				ctx.fill();
				if(pa.life<=0) burst.particles.splice(i,1);
			}

			// shockwave ring
			if(burst.ring){
				const r = burst.ring;
				ctx.strokeStyle = `rgba(180,255,220,${r.alpha})`;
				ctx.lineWidth = 2;
				ctx.beginPath();
				ctx.arc(burst.particles[0] ? burst.particles[0].x : 0, burst.particles[0] ? burst.particles[0].y : 0, r.r, 0, Math.PI*2);
				ctx.stroke();
				r.r += 3.5; r.alpha *= 0.96;
				if(r.r > r.max || r.alpha < 0.03) delete burst.ring;
			}
			if(burst.particles.length===0) bursts.splice(b,1);
		}

		// draw bee
		ctx.globalCompositeOperation = 'source-over';
		const prev = trail.length>1 ? trail[trail.length-2] : p;
		const angle = Math.atan2(p.y - prev.y, p.x - prev.x);
		drawBee(p.x, p.y, angle);

		t += 1/60;
		requestAnimationFrame(draw);
	}
	requestAnimationFrame(draw);
})();


