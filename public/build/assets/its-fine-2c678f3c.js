import{r as o}from"./react-5c625ba7.js";var m=Object.defineProperty,b=Object.defineProperties,y=Object.getOwnPropertyDescriptors,l=Object.getOwnPropertySymbols,O=Object.prototype.hasOwnProperty,P=Object.prototype.propertyIsEnumerable,c=(e,r,t)=>r in e?m(e,r,{enumerable:!0,configurable:!0,writable:!0,value:t}):e[r]=t,p=(e,r)=>{for(var t in r||(r={}))O.call(r,t)&&c(e,t,r[t]);if(l)for(var t of l(r))P.call(r,t)&&c(e,t,r[t]);return e},h=(e,r)=>b(e,y(r));function f(e,r,t){if(!e)return;if(t(e)===!0)return e;let n=r?e.return:e.child;for(;n;){const i=f(n,r,t);if(i)return i;n=r?null:n.sibling}}function v(e){try{return Object.defineProperties(e,{_currentRenderer:{get(){return null},set(){}},_currentRenderer2:{get(){return null},set(){}}})}catch{return e}}const s=v(o.createContext(null));class w extends o.Component{render(){return o.createElement(s.Provider,{value:this._reactInternals},this.props.children)}}const{ReactCurrentOwner:_,ReactCurrentDispatcher:d}=o.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED;function x(){const e=o.useContext(s);if(e===null)throw new Error("its-fine: useFiber must be called within a <FiberProvider />!");const r=o.useId();return o.useMemo(()=>{for(const n of[_==null?void 0:_.current,e,e==null?void 0:e.alternate]){if(!n)continue;const i=f(n,!1,a=>{let u=a.memoizedState;for(;u;){if(u.memoizedState===r)return!0;u=u.next}});if(i)return i}},[e,r])}function E(){var e;const r=x(),[t]=o.useState(()=>new Map);t.clear();let n=r;for(;n;){if(n.type&&typeof n.type=="object"){const a=n.type._context===void 0&&n.type.Provider===n.type?n.type:n.type._context;a&&a!==s&&!t.has(a)&&t.set(a,(e=d==null?void 0:d.current)==null?void 0:e.readContext(v(a)))}n=n.return}return t}function R(){const e=E();return o.useMemo(()=>Array.from(e.keys()).reduce((r,t)=>n=>o.createElement(r,null,o.createElement(t.Provider,h(p({},n),{value:e.get(t)}))),r=>o.createElement(w,p({},r))),[e])}export{w as F,R as u};
