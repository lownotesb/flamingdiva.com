/**
 * plasma-bg.js — Flaming Diva shared WebGL background + shader switcher
 * Include in any page: <script src="../shared/plasma-bg.js"></script>
 * Requires: Rubik + Bebas Neue fonts (auto-injected if missing)
 */
(function () {
  'use strict';

  // ── Fonts ─────────────────────────────────────────────────────────────────
  if (!document.querySelector('link[href*="Bebas+Neue"]')) {
    const lk = document.createElement('link');
    lk.rel = 'stylesheet';
    lk.href = 'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Rubik:wght@300;400;500&display=swap';
    document.head.appendChild(lk);
  }

  // ── CSS ───────────────────────────────────────────────────────────────────
  const style = document.createElement('style');
  style.textContent = `
    #fd-bg-canvas {
      position: fixed; inset: 0;
      width: 100%; height: 100%;
      z-index: 0;
      transition: opacity 0.35s ease;
    }
    .fd-vignette {
      position: fixed; inset: 0;
      background: radial-gradient(ellipse at center, transparent 30%, rgba(4,0,12,0.82) 100%);
      z-index: 1; pointer-events: none;
    }
    .fd-shader-label {
      position: fixed; top: 24px; right: 32px; z-index: 10;
      font-family: 'Bebas Neue', sans-serif; font-size: 13px; letter-spacing: 0.22em;
      color: rgba(255,255,255,0.25); text-transform: uppercase;
      transition: opacity 0.3s ease;
    }
    #fd-shader-open-btn {
      position: fixed; bottom: 28px; left: 28px; z-index: 11;
      width: 38px; height: 38px; border-radius: 50%;
      background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.07);
      backdrop-filter: blur(12px);
      color: rgba(255,255,255,0.35); font-size: 13px;
      cursor: pointer; transition: color 0.2s ease, border-color 0.2s ease, background 0.2s ease;
      display: flex; align-items: center; justify-content: center;
    }
    #fd-shader-open-btn:hover { color: rgba(255,255,255,0.8); border-color: rgba(255,255,255,0.25); }
    #fd-shader-open-btn.switcher-open {
      background: rgba(255,56,0,0.15); border-color: rgba(255,56,0,0.35);
      color: rgba(255,255,255,0.8);
    }
    #fd-shader-open-btn::after {
      content: 'modify your experience';
      position: absolute; top: -61%; left: calc(100% + 12px); transform: translateY(-50%);
      white-space: nowrap;
      background: rgba(0,0,0,0.75); color: rgba(255,255,255,0.65);
      font-family: 'Rubik', sans-serif; font-size: 9px; font-weight: 300;
      letter-spacing: 0.16em; text-transform: uppercase;
      padding: 5px 10px; border-radius: 3px;
      opacity: 0; pointer-events: none; transition: opacity 0.2s ease;
    }
    #fd-shader-open-btn:hover::after { opacity: 1; }
    .fd-shader-switcher {
      position: fixed; bottom: 28px; left: 74px;
      display: flex; gap: 4px; z-index: 10;
      background: rgba(0,0,0,0.5);
      padding: 5px;
      border: 1px solid rgba(255,255,255,0.07);
      backdrop-filter: blur(12px);
      transform: translateX(-120%); opacity: 0;
      transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.28s ease;
      pointer-events: none;
    }
    .fd-shader-switcher.open {
      transform: translateX(0); opacity: 1;
      pointer-events: auto;
    }
    .fd-sh-btn {
      padding: 9px 22px;
      font-family: 'Rubik', sans-serif; font-size: 10px; font-weight: 400;
      letter-spacing: 0.2em; text-transform: uppercase;
      color: rgba(255,255,255,0.4);
      background: transparent;
      border: 1px solid rgba(255,255,255,0.08);
      cursor: pointer; transition: all 0.2s ease;
    }
    .fd-sh-btn:hover { color: rgba(255,255,255,0.75); border-color: rgba(255,255,255,0.25); }
    .fd-sh-btn.active {
      color: #fff;
      background: linear-gradient(90deg, rgba(255,56,0,0.85), rgba(148,0,255,0.85));
      border-color: transparent;
    }
    .fd-sh-close {
      padding: 9px 14px;
      font-family: 'Rubik', sans-serif; font-size: 14px; font-weight: 300;
      color: rgba(255,255,255,0.3);
      background: transparent;
      border: 1px solid rgba(255,255,255,0.08);
      cursor: pointer; transition: all 0.2s ease; line-height: 1;
    }
    .fd-sh-close:hover { color: rgba(255,255,255,0.8); border-color: rgba(255,255,255,0.25); }
    #fd-shader-tune-btn {
      position: fixed; bottom: 28px; right: 28px; z-index: 10;
      width: 36px; height: 36px;
      background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.07);
      backdrop-filter: blur(12px);
      color: rgba(255,255,255,0.3); font-size: 15px;
      cursor: pointer; transition: all 0.2s ease;
      display: flex; align-items: center; justify-content: center;
    }
    #fd-shader-tune-btn:hover { color: rgba(255,255,255,0.8); border-color: rgba(255,255,255,0.25); }
    #fd-param-modal {
      position: fixed; top: 50%; left: 50%; transform: translate(-50%,-50%);
      width: 340px; background: rgba(6,0,14,0.90);
      border: 1px solid rgba(255,255,255,0.10);
      backdrop-filter: blur(24px); z-index: 50; display: none;
    }
    #fd-param-modal.open { display: block; }
    #fd-param-modal .pm-header {
      display: flex; justify-content: space-between; align-items: center;
      padding: 14px 18px; border-bottom: 1px solid rgba(255,255,255,0.07); cursor: move;
    }
    #fd-param-modal .pm-title {
      font-family: 'Bebas Neue', sans-serif; font-size: 13px;
      letter-spacing: 0.22em; color: rgba(255,255,255,0.85);
    }
    #fd-param-modal .pm-close {
      background: none; border: none; color: rgba(255,255,255,0.35);
      font-size: 20px; line-height: 1; cursor: pointer; padding: 0; transition: color 0.15s;
    }
    #fd-param-modal .pm-close:hover { color: #fff; }
    #fd-param-modal .pm-body { padding: 18px 18px 14px; }
    #fd-param-modal .pm-row {
      display: grid; grid-template-columns: 86px 1fr 58px;
      align-items: center; gap: 10px; margin-bottom: 13px;
    }
    #fd-param-modal .pm-label {
      font-size: 10px; font-weight: 300; letter-spacing: 0.14em;
      color: rgba(255,255,255,0.45); text-transform: uppercase;
      font-family: 'Rubik', sans-serif;
    }
    #fd-param-modal input[type="range"] {
      -webkit-appearance: none; appearance: none; width: 100%; height: 2px;
      background: rgba(255,255,255,0.15); outline: none; cursor: pointer; border-radius: 1px;
    }
    #fd-param-modal input[type="range"]::-webkit-slider-thumb {
      -webkit-appearance: none; width: 13px; height: 13px; border-radius: 50%;
      background: linear-gradient(135deg,#FF3800,#9400FF); cursor: pointer;
    }
    #fd-param-modal input[type="range"]::-moz-range-thumb {
      width: 13px; height: 13px; border-radius: 50%; border: none;
      background: linear-gradient(135deg,#FF3800,#9400FF); cursor: pointer;
    }
    #fd-param-modal input[type="number"] {
      background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.10);
      color: rgba(255,255,255,0.75); font-family: 'Rubik',sans-serif;
      font-size: 10px; font-weight: 300; padding: 4px 5px; width: 100%;
      text-align: right; outline: none; -moz-appearance: textfield; appearance: textfield;
    }
    #fd-param-modal input[type="number"]::-webkit-inner-spin-button,
    #fd-param-modal input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; }
    #fd-param-modal input[type="number"]:focus { border-color: rgba(148,0,255,0.5); }
    #fd-param-modal .pm-reset {
      margin-top: 6px; width: 100%; padding: 8px;
      background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
      color: rgba(255,255,255,0.35); font-family: 'Rubik',sans-serif;
      font-size: 9px; letter-spacing: 0.18em; text-transform: uppercase;
      cursor: pointer; transition: all 0.2s;
    }
    #fd-param-modal .pm-reset:hover { background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.65); }
  `;
  document.head.appendChild(style);

  // ── DOM elements ──────────────────────────────────────────────────────────
  const canvas = document.createElement('canvas');
  canvas.id = 'fd-bg-canvas';
  document.body.insertBefore(canvas, document.body.firstChild);

  const vignette = document.createElement('div');
  vignette.className = 'fd-vignette';
  document.body.insertBefore(vignette, canvas.nextSibling);

  const shaderLabel = document.createElement('div');
  shaderLabel.className = 'fd-shader-label';
  shaderLabel.id = 'fd-shader-label';
  document.body.appendChild(shaderLabel);

  // Param modal
  const modal = document.createElement('div');
  modal.id = 'fd-param-modal';
  modal.innerHTML = `
    <div class="pm-header" id="fd-pm-header">
      <span class="pm-title" id="fd-pm-title">PLASMA — PARAMETERS</span>
      <button class="pm-close" id="fd-pm-close">×</button>
    </div>
    <div class="pm-body" id="fd-pm-body">
      <button class="pm-reset" id="fd-pm-reset">↺  Reset to defaults</button>
    </div>
  `;
  document.body.appendChild(modal);

  // Tune button
  const tuneBtn = document.createElement('button');
  tuneBtn.id = 'fd-shader-tune-btn';
  tuneBtn.setAttribute('aria-label', 'Customize background');
  tuneBtn.textContent = '⚙';
  document.body.appendChild(tuneBtn);

  // Switcher open pill
  const openBtn = document.createElement('button');
  openBtn.id = 'fd-shader-open-btn';
  openBtn.setAttribute('aria-label', 'Modify your experience');
  openBtn.textContent = '✦';
  document.body.appendChild(openBtn);

  // Switcher slide-out
  const switcher = document.createElement('div');
  switcher.className = 'fd-shader-switcher';
  switcher.id = 'fd-shader-switcher';
  switcher.innerHTML = `
    <button class="fd-sh-btn active" data-idx="0">Plasma</button>
    <button class="fd-sh-btn" data-idx="1">Lava</button>
    <button class="fd-sh-btn" data-idx="2">Aurora</button>
    <button class="fd-sh-btn" data-idx="3">Acid</button>
    <button class="fd-sh-btn" data-idx="4">Trip</button>
    <button class="fd-sh-btn" data-idx="5">Pane</button>
    <button class="fd-sh-close" id="fd-shader-close-btn" aria-label="Close">✕</button>
  `;
  document.body.appendChild(switcher);

  // ── GLSL shaders ──────────────────────────────────────────────────────────
  const VERT = `
    attribute vec2 a_pos;
    void main() { gl_Position = vec4(a_pos, 0.0, 1.0); }
  `;

  const NOISE_LIB = `
    precision mediump float;
    uniform float u_time;
    uniform vec2  u_res;
    vec2 _h2(vec2 p) {
      p = vec2(dot(p,vec2(127.1,311.7)), dot(p,vec2(269.5,183.3)));
      return -1.0 + 2.0*fract(sin(p)*43758.5453123);
    }
    float _n(vec2 p) {
      vec2 i=floor(p); vec2 f=fract(p);
      vec2 u=f*f*(3.0-2.0*f);
      return mix(mix(dot(_h2(i+vec2(0,0)),f-vec2(0,0)),dot(_h2(i+vec2(1,0)),f-vec2(1,0)),u.x),
                 mix(dot(_h2(i+vec2(0,1)),f-vec2(0,1)),dot(_h2(i+vec2(1,1)),f-vec2(1,1)),u.x),u.y);
    }
    float _fbm(vec2 p) {
      float v=0.0,a=0.5;
      for(int i=0;i<5;i++){v+=a*_n(p);p=p*2.1+vec2(1.7,9.2);a*=0.5;}
      return v;
    }
    float _hash(vec2 p){return fract(sin(dot(p,vec2(127.1,311.7)))*43758.5453);}
  `;

  const FRAG_PLASMA = NOISE_LIB + `
    uniform float u_speed; uniform float u_warp; uniform float u_contrast;
    uniform float u_hue;   uniform float u_vig;
    vec3 _palette(float t) {
      vec3 a=vec3(0.04,0.00,0.10), b=vec3(0.60,0.10,0.50);
      vec3 c=vec3(0.80,0.30,0.60), d=vec3(0.00,0.50,1.00);
      return a + b*cos(6.28318*(c*t+d));
    }
    void main() {
      vec2 uv=(gl_FragCoord.xy-0.5*u_res)/min(u_res.x,u_res.y);
      float t=u_time*u_speed;
      vec2 q=vec2(_fbm(uv+t), _fbm(uv+vec2(1.0)));
      vec2 r=vec2(_fbm(uv+u_warp*q+vec2(1.7,9.2)+0.15*t),
                  _fbm(uv+u_warp*q+vec2(8.3,2.8)+0.126*t));
      float f=_fbm(uv+u_warp*r);
      f=pow(clamp(f*0.5+0.5,0.0,1.0),u_contrast);
      vec3 col=_palette(f+u_hue*t);
      float vign=1.0-smoothstep(u_vig,1.4,length(uv));
      col*=vign*0.9+0.1;
      gl_FragColor=vec4(col,1.0);
    }
  `;

  const FRAG_LAVA = NOISE_LIB + `
    uniform float u_speed; uniform float u_heat; uniform float u_glow;
    void main() {
      vec2 uv=(gl_FragCoord.xy-0.5*u_res)/min(u_res.x,u_res.y);
      float t=u_time*u_speed;
      vec2 q=vec2(_fbm(uv*1.2+vec2(t,0.0)), _fbm(uv*1.2+vec2(0.0,t*0.7)));
      float f=_fbm(uv*1.0+2.5*q+vec2(t*0.4,-t*0.3));
      f=clamp(f*0.5+0.5,0.0,1.0);
      vec3 col=mix(vec3(0.0),        vec3(0.22,0.0,0.0),  smoothstep(0.0,0.38,f));
      col=mix(col, vec3(0.65,0.04,0.0), smoothstep(0.33,0.58,f));
      col=mix(col, vec3(1.0,0.28,0.0),  smoothstep(0.52,0.72,f));
      col=mix(col, vec3(1.0,0.85,0.15), smoothstep(0.68,0.92,f));
      col+=vec3(0.6,0.08,0.0)*pow(f,5.0)*u_heat;
      float shimmer=_n(uv*8.0+vec2(t*2.0,0.0))*0.5+0.5;
      col+=vec3(0.3,0.04,0.0)*shimmer*pow(f,3.0)*u_glow;
      float vign=1.0-smoothstep(0.35,1.3,length(uv));
      col*=vign*0.85+0.15;
      gl_FragColor=vec4(clamp(col,0.0,1.0),1.0);
    }
  `;

  const FRAG_AURORA = NOISE_LIB + `
    uniform float u_speed; uniform float u_intensity; uniform float u_stars;
    uniform float u_band_w; uniform float u_wave_amp; uniform float u_organic;
    uniform float u_curtain; uniform float u_hue_speed;
    void main() {
      vec2 uv=gl_FragCoord.xy/u_res;
      float t=u_time*u_speed;
      vec3 col=vec3(0.003,0.006,0.025);
      col+=vec3(0.0,0.012,0.035)*(1.0-uv.y)*0.6;
      for(int i=0;i<5;i++){
        float fi=float(i);
        float yc=0.25+fi*0.10+0.045*sin(t*0.22+fi*1.85);
        float nwCoarse=_fbm(vec2(uv.x*1.1+fi*4.2,t*0.16+fi*0.7));
        float nwFine  =_fbm(vec2(uv.x*4.5+fi*1.8,t*0.30+fi*1.9));
        float wave=yc+u_wave_amp*(nwCoarse+u_organic*nwFine*0.35);
        float dist=abs(uv.y-wave);
        float cn=_fbm(vec2(uv.x*6.0+fi*2.3,t*0.12+fi*1.1))*0.5+0.5;
        float curtain=mix(1.0,cn,u_curtain);
        float band=exp(-dist*u_band_w)*(0.3+0.35*sin(t*0.65+fi*1.05+uv.x*3.8))*curtain;
        float hue=fi*0.18+t*u_hue_speed;
        vec3 aCol=0.5+0.5*cos(6.28318*(hue+vec3(0.0,0.33,0.67)));
        col+=band*aCol*u_intensity;
      }
      vec2 sg=uv*320.0; vec2 sgC=floor(sg); vec2 sgF=fract(sg)-0.5;
      float sh=_hash(sgC);
      vec2 jit=vec2(_hash(sgC+vec2(7.3,2.9)),_hash(sgC+vec2(3.1,8.7)))-0.5;
      float tw=0.5+0.5*sin(t*2.8+_hash(sgC+0.3)*6.28318);
      col+=smoothstep(0.22,0.0,length(sgF-jit*0.4))*tw*step(0.991,sh)*vec3(0.65,0.75,1.0)*u_stars;
      vec2 sg2=uv*80.0; vec2 sg2C=floor(sg2); vec2 sg2F=fract(sg2)-0.5;
      float sh2=_hash(sg2C+5.0);
      vec2 jit2=vec2(_hash(sg2C+vec2(1.5,6.2)),_hash(sg2C+vec2(9.1,0.4)))-0.5;
      col+=smoothstep(0.28,0.0,length(sg2F-jit2*0.3))*_hash(sg2C+6.0)*step(0.955,sh2)*vec3(0.4,0.5,0.9)*0.35;
      col=clamp(col,0.0,1.0);
      gl_FragColor=vec4(col,1.0);
    }
  `;

  const FRAG_ACID = NOISE_LIB + `
    uniform float u_speed; uniform float u_rotation; uniform float u_sectors;
    uniform float u_saturation; uniform float u_zoom; uniform float u_freq;
    uniform float u_hue; uniform float u_hue_off;
    void main() {
      vec2 uv=(gl_FragCoord.xy-0.5*u_res)/min(u_res.x,u_res.y)*u_zoom;
      float t=u_time*u_speed;
      float ca=cos(t*u_rotation), sa=sin(t*u_rotation);
      uv=vec2(ca*uv.x-sa*uv.y, sa*uv.x+ca*uv.y);
      float a=atan(uv.y,uv.x);
      float r=length(uv);
      float sector=3.14159/u_sectors;
      a=mod(a,sector*2.0); a=abs(a-sector);
      uv=r*vec2(cos(a),sin(a))*u_freq;
      float f=0.0;
      f+=sin(uv.x*4.5+t)*cos(uv.y*3.2-t*0.9);
      f+=sin(uv.x*3.1-t*0.7+uv.y*2.4)*0.65;
      f+=cos(length(uv)*6.0-t*1.3)*0.55;
      f+=sin((uv.x+uv.y)*3.0+t*0.8)*0.4;
      f+=cos(uv.x*uv.y*1.5+t*1.1)*0.25;
      f=f*0.2+0.5;
      vec3 col=0.5+0.5*cos(6.28318*(f+t*u_hue+u_hue_off+vec3(0.0,0.33,0.67)));
      float lum=dot(col,vec3(0.299,0.587,0.114));
      col=mix(vec3(lum),col,u_saturation);
      col=pow(clamp(col,0.0,1.0),vec3(0.82));
      col*=0.85+0.15*smoothstep(0.0,0.6,r);
      gl_FragColor=vec4(col,1.0);
    }
  `;

  const FRAG_VOID = NOISE_LIB + `
    uniform float u_speed; uniform float u_warp; uniform float u_hue;
    uniform float u_sat; uniform float u_zoom;
    void main() {
      vec2 uv=(gl_FragCoord.xy-0.5*u_res)/min(u_res.x,u_res.y)*u_zoom;
      float t=u_time*u_speed;
      vec2 q=vec2(_fbm(uv*1.5+t*0.5), _fbm(uv*1.5+vec2(5.2,1.3)-t*0.4));
      vec2 r=vec2(_fbm(uv+u_warp*q+vec2(1.7,9.2)+t*0.30),
                  _fbm(uv+u_warp*q+vec2(8.3,2.8)-t*0.25));
      float f=_fbm(uv+u_warp*r)*0.5+0.5;
      vec3 col=0.5+0.5*cos(6.28318*(f+t*u_hue+vec3(0.0,0.33,0.67)));
      float lum2=dot(col,vec3(0.299,0.587,0.114));
      col=mix(vec3(lum2),col,u_sat);
      col=pow(clamp(col,0.0,1.0),vec3(0.75));
      gl_FragColor=vec4(col,1.0);
    }
  `;

  const FRAG_PANE = NOISE_LIB + `
    uniform float u_speed; uniform float u_freq; uniform float u_depth;
    uniform float u_organic; uniform float u_hue; uniform float u_sat;
    uniform float u_angle;
    void main() {
      vec2 uv=(gl_FragCoord.xy-0.5*u_res)/min(u_res.x,u_res.y);
      float t=u_time*u_speed;
      float ca=cos(t*0.04),sa=sin(t*0.04);
      uv=vec2(ca*uv.x-sa*uv.y,sa*uv.x+ca*uv.y);
      float ga=u_angle*3.14159,cg=cos(ga),sg=sin(ga);
      uv=vec2(cg*uv.x-sg*uv.y,sg*uv.x+cg*uv.y);
      vec2 p=uv*u_freq;
      float f=0.0; float edgeAcc=0.0;
      for(int i=0;i<6;i++){
        p=abs(fract(p)-0.5)*2.0;
        float ew=0.05+float(i)*0.015;
        edgeAcc+=(1.0-smoothstep(0.0,ew,min(p.x,p.y)))/pow(1.6,float(i));
        float nw=_fbm(p*1.8+vec2(t*0.11,t*0.08)+float(i)*1.9)*u_organic;
        f+=(dot(p,p)*0.5+nw*0.25)/pow(u_depth,float(i));
        p*=u_depth;
      }
      float pane=clamp(edgeAcc,0.0,1.5);
      vec3 col=0.5+0.5*cos(6.28318*(f*0.45+t*u_hue+vec3(0.0,0.33,0.67)));
      float lum3=dot(col,vec3(0.299,0.587,0.114));
      col=mix(vec3(lum3),col,u_sat);
      col=mix(col,min(col*2.0+0.15,vec3(1.0)),pane*0.55);
      col=pow(clamp(col,0.0,1.0),vec3(0.78));
      gl_FragColor=vec4(col,1.0);
    }
  `;

  // ── Shader parameter definitions ──────────────────────────────────────────
  const SHADER_PARAMS = [
    [ // 0: Plasma
      { label: 'Speed',     uniform: 'u_speed',    min: 0.01, max: 0.60, step: 0.01,  def: 0.11  },
      { label: 'Warp',      uniform: 'u_warp',     min: 0.5,  max: 10.0, step: 0.1,   def: 4.0   },
      { label: 'Contrast',  uniform: 'u_contrast', min: 0.3,  max: 3.0,  step: 0.05,  def: 1.4   },
      { label: 'Hue Drift', uniform: 'u_hue',      min: 0.0,  max: 1.0,  step: 0.01,  def: 0.1   },
      { label: 'Vignette',  uniform: 'u_vig',      min: 0.1,  max: 1.4,  step: 0.05,  def: 0.5   },
    ],
    [ // 1: Lava
      { label: 'Speed',   uniform: 'u_speed', min: 0.01, max: 0.30, step: 0.005, def: 0.07 },
      { label: 'Heat',    uniform: 'u_heat',  min: 0.0,  max: 2.5,  step: 0.05,  def: 0.7  },
      { label: 'Shimmer', uniform: 'u_glow',  min: 0.0,  max: 1.5,  step: 0.05,  def: 0.4  },
    ],
    [ // 2: Aurora
      { label: 'Speed',      uniform: 'u_speed',     min: 0.05, max: 0.80, step: 0.01,  def: 0.22  },
      { label: 'Intensity',  uniform: 'u_intensity', min: 0.1,  max: 2.5,  step: 0.05,  def: 0.9   },
      { label: 'Stars',      uniform: 'u_stars',     min: 0.0,  max: 2.0,  step: 0.05,  def: 0.7   },
      { label: 'Band Width', uniform: 'u_band_w',    min: 8.0,  max: 80.0, step: 1.0,   def: 28.0  },
      { label: 'Wave Amp',   uniform: 'u_wave_amp',  min: 0.0,  max: 0.30, step: 0.005, def: 0.08  },
      { label: 'Organic',    uniform: 'u_organic',   min: 0.0,  max: 2.0,  step: 0.05,  def: 0.6   },
      { label: 'Curtain',    uniform: 'u_curtain',   min: 0.0,  max: 1.0,  step: 0.05,  def: 0.55  },
      { label: 'Hue Speed',  uniform: 'u_hue_speed', min: 0.0,  max: 0.15, step: 0.005, def: 0.035 },
    ],
    [ // 3: Acid
      { label: 'Speed',      uniform: 'u_speed',      min: 0.05, max: 1.2,  step: 0.01,  def: 0.38  },
      { label: 'Rotation',   uniform: 'u_rotation',   min: 0.0,  max: 0.6,  step: 0.01,  def: 0.15  },
      { label: 'Sectors',    uniform: 'u_sectors',    min: 2.0,  max: 16.0, step: 1.0,   def: 8.0   },
      { label: 'Saturation', uniform: 'u_saturation', min: 0.5,  max: 4.0,  step: 0.05,  def: 1.85  },
      { label: 'Zoom',       uniform: 'u_zoom',       min: 0.2,  max: 4.0,  step: 0.05,  def: 1.0   },
      { label: 'Wave Freq',  uniform: 'u_freq',       min: 0.2,  max: 4.0,  step: 0.05,  def: 1.0   },
      { label: 'Hue Speed',  uniform: 'u_hue',        min: 0.0,  max: 0.8,  step: 0.01,  def: 0.10  },
      { label: 'Hue Offset', uniform: 'u_hue_off',    min: 0.0,  max: 1.0,  step: 0.01,  def: 0.0   },
    ],
    [ // 4: Trip
      { label: 'Speed',     uniform: 'u_speed', min: 0.01, max: 0.40, step: 0.01,  def: 0.12 },
      { label: 'Warp',      uniform: 'u_warp',  min: 1.0,  max: 12.0, step: 0.25,  def: 6.0  },
      { label: 'Hue Speed', uniform: 'u_hue',   min: 0.0,  max: 1.0,  step: 0.01,  def: 0.20 },
      { label: 'Saturate',  uniform: 'u_sat',   min: 0.5,  max: 5.0,  step: 0.1,   def: 2.2  },
      { label: 'Zoom',      uniform: 'u_zoom',  min: 0.3,  max: 3.0,  step: 0.05,  def: 1.0  },
    ],
    [ // 5: Pane
      { label: 'Speed',     uniform: 'u_speed',   min: 0.01, max: 0.30, step: 0.005, def: 0.07 },
      { label: 'Freq',      uniform: 'u_freq',    min: 0.5,  max: 6.0,  step: 0.1,   def: 1.8  },
      { label: 'Depth',     uniform: 'u_depth',   min: 1.2,  max: 3.0,  step: 0.05,  def: 1.65 },
      { label: 'Organic',   uniform: 'u_organic', min: 0.0,  max: 1.5,  step: 0.05,  def: 0.45 },
      { label: 'Hue Speed', uniform: 'u_hue',     min: 0.0,  max: 0.8,  step: 0.01,  def: 0.14 },
      { label: 'Saturate',  uniform: 'u_sat',     min: 0.5,  max: 5.0,  step: 0.1,   def: 2.8  },
      { label: 'Angle',     uniform: 'u_angle',   min: 0.0,  max: 1.0,  step: 0.01,  def: 0.0  },
    ],
  ];
  SHADER_PARAMS.forEach(group => group.forEach(p => { p.value = p.def; }));

  const NAMES = ['Plasma', 'Lava', 'Aurora', 'Acid', 'Trip', 'Pane'];
  const FRAGS = [FRAG_PLASMA, FRAG_LAVA, FRAG_AURORA, FRAG_ACID, FRAG_VOID, FRAG_PANE];

  // ── WebGL setup ───────────────────────────────────────────────────────────
  const gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');

  function resize() {
    canvas.width  = window.innerWidth;
    canvas.height = window.innerHeight;
    if (gl) gl.viewport(0, 0, canvas.width, canvas.height);
  }
  resize();
  window.addEventListener('resize', resize);

  if (!gl) {
    canvas.style.display = 'none';
    document.body.style.background = 'linear-gradient(135deg,#06000E 0%,#1a003a 40%,#3d0020 70%,#06000E 100%)';
    return;
  }

  function compileShader(type, src) {
    const s = gl.createShader(type);
    gl.shaderSource(s, src); gl.compileShader(s);
    if (!gl.getShaderParameter(s, gl.COMPILE_STATUS)) console.warn(gl.getShaderInfoLog(s));
    return s;
  }

  const vertShader = compileShader(gl.VERTEX_SHADER, VERT);
  const programs = FRAGS.map((fragSrc, i) => {
    const prog = gl.createProgram();
    gl.attachShader(prog, vertShader);
    gl.attachShader(prog, compileShader(gl.FRAGMENT_SHADER, fragSrc));
    gl.linkProgram(prog);
    if (!gl.getProgramParameter(prog, gl.LINK_STATUS)) console.warn(gl.getProgramInfoLog(prog));
    const uniforms = {};
    SHADER_PARAMS[i].forEach(p => { uniforms[p.uniform] = gl.getUniformLocation(prog, p.uniform); });
    return {
      prog,
      aPos:   gl.getAttribLocation(prog, 'a_pos'),
      uTime:  gl.getUniformLocation(prog, 'u_time'),
      uRes:   gl.getUniformLocation(prog, 'u_res'),
      uniforms,
    };
  });

  const buf = gl.createBuffer();
  gl.bindBuffer(gl.ARRAY_BUFFER, buf);
  gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1,-1, 1,-1, -1,1, 1,1]), gl.STATIC_DRAW);

  // ── localStorage persistence ──────────────────────────────────────────────
  function savePrefs() {
    const state = { idx: current, params: {} };
    SHADER_PARAMS[current].forEach(p => { state.params[p.uniform] = p.value; });
    try { localStorage.setItem('fd_shader', JSON.stringify(state)); } catch(e) {}
  }

  let current = 0;
  const start = performance.now();

  try {
    const saved = JSON.parse(localStorage.getItem('fd_shader') || 'null');
    if (saved && saved.idx >= 0 && saved.idx < NAMES.length) {
      current = saved.idx;
      SHADER_PARAMS[saved.idx].forEach(p => {
        if (saved.params && saved.params[p.uniform] !== undefined) p.value = saved.params[p.uniform];
      });
    }
  } catch(e) {}

  // ── Render loop ───────────────────────────────────────────────────────────
  function frame() {
    const p = programs[current];
    gl.useProgram(p.prog);
    gl.bindBuffer(gl.ARRAY_BUFFER, buf);
    gl.enableVertexAttribArray(p.aPos);
    gl.vertexAttribPointer(p.aPos, 2, gl.FLOAT, false, 0, 0);
    gl.uniform1f(p.uTime, (performance.now() - start) / 1000);
    gl.uniform2f(p.uRes,  canvas.width, canvas.height);
    SHADER_PARAMS[current].forEach(param => { gl.uniform1f(p.uniforms[param.uniform], param.value); });
    gl.drawArrays(gl.TRIANGLE_STRIP, 0, 4);
    requestAnimationFrame(frame);
  }
  frame();

  // ── Parameter Modal ───────────────────────────────────────────────────────
  const pmTitle  = document.getElementById('fd-pm-title');
  const pmBody   = document.getElementById('fd-pm-body');
  const pmReset  = document.getElementById('fd-pm-reset');

  function buildModal(idx) {
    pmTitle.textContent = NAMES[idx].toUpperCase() + ' — PARAMETERS';
    pmBody.querySelectorAll('.pm-row').forEach(r => r.remove());
    SHADER_PARAMS[idx].forEach(p => {
      const row    = document.createElement('div');
      const lbl    = document.createElement('span');
      const slider = document.createElement('input');
      const num    = document.createElement('input');
      row.className = 'pm-row'; lbl.className = 'pm-label'; lbl.textContent = p.label;
      slider.type = 'range';  slider.min = p.min; slider.max = p.max; slider.step = p.step; slider.value = p.value;
      num.type    = 'number'; num.min    = p.min; num.max    = p.max; num.step    = p.step; num.value    = p.value;
      const sync = v => { p.value = v; slider.value = v; num.value = v; savePrefs(); };
      slider.addEventListener('input',  () => sync(parseFloat(slider.value)));
      num.addEventListener('change', () => { const v = Math.min(p.max, Math.max(p.min, parseFloat(num.value) || p.def)); sync(v); });
      row.append(lbl, slider, num);
      pmBody.insertBefore(row, pmReset);
    });
  }

  function openModal(idx)  { buildModal(idx); modal.classList.add('open'); }
  function closeModal()    { modal.classList.remove('open'); }

  document.getElementById('fd-pm-close').addEventListener('click', closeModal);
  document.addEventListener('keydown', e => { if (e.key === 'Escape' && modal.classList.contains('open')) closeModal(); });
  pmReset.addEventListener('click', () => {
    SHADER_PARAMS[current].forEach(p => { p.value = p.def; });
    buildModal(current); savePrefs();
  });

  // Draggable
  (function() {
    let dragging = false, ox = 0, oy = 0;
    document.getElementById('fd-pm-header').addEventListener('mousedown', e => {
      dragging = true;
      const rect = modal.getBoundingClientRect();
      modal.style.transform = 'none';
      modal.style.top  = rect.top  + 'px';
      modal.style.left = rect.left + 'px';
      ox = e.clientX - rect.left; oy = e.clientY - rect.top;
      e.preventDefault();
    });
    document.addEventListener('mousemove', e => { if (!dragging) return; modal.style.left = (e.clientX - ox) + 'px'; modal.style.top = (e.clientY - oy) + 'px'; });
    document.addEventListener('mouseup', () => { dragging = false; });
  })();

  // ── Switcher UI ───────────────────────────────────────────────────────────
  const buttons   = switcher.querySelectorAll('.fd-sh-btn');
  const closeBtn  = document.getElementById('fd-shader-close-btn');

  buttons.forEach(b => b.classList.toggle('active', parseInt(b.dataset.idx) === current));
  shaderLabel.textContent = NAMES[current];

  function openSwitcher()  { switcher.classList.add('open'); openBtn.classList.add('switcher-open'); }
  function closeSwitcher() { switcher.classList.remove('open'); openBtn.classList.remove('switcher-open'); }

  openBtn.addEventListener('click', () => {
    switcher.classList.contains('open') ? closeSwitcher() : openSwitcher();
  });
  closeBtn.addEventListener('click', closeSwitcher);

  buttons.forEach(btn => {
    btn.addEventListener('click', () => {
      const idx = parseInt(btn.dataset.idx);
      buttons.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      shaderLabel.style.opacity = '0';
      if (idx !== current) {
        canvas.style.opacity = '0';
        setTimeout(() => {
          current = idx; savePrefs();
          canvas.style.opacity = '1';
          shaderLabel.textContent = NAMES[idx];
          setTimeout(() => { shaderLabel.style.opacity = '1'; }, 350);
        }, 350);
      } else {
        shaderLabel.textContent = NAMES[idx];
        setTimeout(() => { shaderLabel.style.opacity = '1'; }, 100);
      }
      openModal(idx);
    });
  });

  tuneBtn.addEventListener('click', () => openModal(current));

  // ── Dissolve / screensaver ────────────────────────────────────────────────
  // Preserved elements (always visible during dissolve)
  const FD_PRESERVE = new Set([
    'fd-bg-canvas', 'fd-shader-label', 'fd-shader-open-btn',
    'fd-shader-switcher', 'fd-shader-tune-btn', 'fd-param-modal',
  ]);

  function dissolveTargets() {
    return Array.from(document.body.children).filter(el => {
      const t = el.tagName;
      if (t === 'SCRIPT' || t === 'STYLE') return false;
      if (FD_PRESERVE.has(el.id)) return false;
      if (el.classList.contains('fd-vignette')) return false;
      return true;
    });
  }

  let _dissolved = false;
  let _idleTimer  = null;

  function fdDissolve() {
    if (_dissolved) return;
    _dissolved = true;
    dissolveTargets().forEach(el => {
      el.style.transition    = 'opacity 5s ease';
      el.style.opacity       = '0';
      el.style.pointerEvents = 'none';
    });
  }

  function fdRestore() {
    if (!_dissolved) return;
    _dissolved = false;
    dissolveTargets().forEach(el => {
      el.style.transition    = 'opacity 15s ease';
      el.style.opacity       = '';
      el.style.pointerEvents = '';
    });
    fdResetIdle();
  }

  function fdResetIdle() {
    clearTimeout(_idleTimer);
    _idleTimer = setTimeout(fdDissolve, 120000); // 2 minutes
  }

  // Hover shader label → slowly dissolve into screensaver
  shaderLabel.addEventListener('mouseenter', fdDissolve);

  // Mouse movement resets idle timer only — does NOT restore content
  document.addEventListener('mousemove', fdResetIdle, { passive: true });

  // Only a deliberate click/tap restores page content
  ['mousedown', 'touchstart'].forEach(evt => {
    document.addEventListener(evt, () => { fdRestore(); fdResetIdle(); }, { passive: true });
  });

  // Persist shader choice on page navigation
  window.addEventListener('beforeunload', savePrefs);

  fdResetIdle(); // start the idle timer

})();
