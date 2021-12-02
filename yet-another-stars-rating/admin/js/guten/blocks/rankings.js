(()=>{"use strict";var e,t,a,r,n,l,s,o={245:(e,t,a)=>{a.r(t),a.d(t,{YasrBlocksPanel:()=>b,YasrDivRatingOverall:()=>k,YasrNoSettingsPanel:()=>R,YasrPrintInputId:()=>h,YasrPrintSelectSize:()=>d,YasrProText:()=>E,yasrLabelSelectSize:()=>c,yasrLeaveThisBlankText:()=>p,yasrOptionalText:()=>o,yasrOverallDescription:()=>v,yasrSelectSizeChoose:()=>i,yasrSelectSizeLarge:()=>g,yasrSelectSizeMedium:()=>m,yasrSelectSizeSmall:()=>u,yasrVisitorVotesDescription:()=>y});var r=a(245),n=wp.i18n.__,l=wp.components.PanelBody,s=wp.blockEditor.InspectorControls,o=n("All these settings are optional","yet-another-stars-rating"),c=n("Choose Size","yet-another-stars-rating"),i=n("Choose stars size","yet-another-stars-rating"),u=n("Small","yet-another-stars-rating"),m=n("Medium","yet-another-stars-rating"),g=n("Large","yet-another-stars-rating"),p=n("Leave this blank if you don't know what you're doing.","yet-another-stars-rating"),v=n("Remember: only the post author can rate here.","yet-another-stars-rating"),y=n("This is the star set where your users will be able to vote","yet-another-stars-rating");function d(e){return React.createElement("form",null,React.createElement("select",{value:e.size,onChange:function(t){return(0,e.setAttributes)({size:(a=t).target.querySelector("option:checked").value}),void a.preventDefault();var a}},React.createElement("option",{value:"--"},r.yasrSelectSizeChoose),React.createElement("option",{value:"small"},r.yasrSelectSizeSmall),React.createElement("option",{value:"medium"},r.yasrSelectSizeMedium),React.createElement("option",{value:"large"},r.yasrSelectSizeLarge)))}function h(e){var t;return!1!==e.postId&&(t=e.postId),React.createElement("div",null,React.createElement("input",{type:"text",size:"4",defaultValue:t,onKeyPress:function(t){return function(e,t){if("Enter"===t.key){var a=t.target.value;!0!==/^\d+$/.test(a)&&""!==a||e({postId:a}),t.preventDefault()}}(e.setAttributes,t)}}))}function E(){var e=n("To be able to customize this ranking, you need","yet-another-stars-rating"),t=n("You can buy the plugin, including support, updates and upgrades, on","yet-another-stars-rating");return React.createElement("h3",null,e," ",React.createElement("a",{href:"https://yetanotherstarsrating.com/?utm_source=wp-plugin&utm_medium=gutenberg_panel&utm_campaign=yasr_editor_screen&utm_content=rankings#yasr-pro"},"Yasr Pro."),React.createElement("br",null),t," ",React.createElement("a",{href:"https://yetanotherstarsrating.com/?utm_source=wp-plugin&utm_medium=gutenberg_panel&utm_campaign=yasr_editor_screen&utm_content=rankings"},"yetanotherstarsrating.com"))}function R(e){return React.createElement("div",null,React.createElement(E,null))}function b(e){var t;return"visitors"===e.block&&(t=y),"overall"===e.block&&(t=v),React.createElement(s,null,"overall"===e.block&&React.createElement(k,null),React.createElement(l,{title:"Settings"},React.createElement("h3",null,o),React.createElement("div",{className:"yasr-guten-block-panel"},React.createElement("label",null,c),React.createElement("div",null,React.createElement(d,{size:e.size,setAttributes:e.setAttributes}))),React.createElement("div",{className:"yasr-guten-block-panel"},React.createElement("label",null,"Post ID"),React.createElement(h,{postId:e.postId,setAttributes:e.setAttributes}),React.createElement("div",{className:"yasr-guten-block-explain"},p)),React.createElement("div",{className:"yasr-guten-block-panel"},t)))}function k(e){if(!0===JSON.parse(yasrConstantGutenberg.isFseElement))return React.createElement("div",{className:"yasr-guten-block-panel yasr-guten-block-panel-center"},React.createElement("div",null,n("This is a template file, you can't rate here. You need to insert the rating inside the single post or page","yet-another-stars-rating")),React.createElement("br",null));var t=n("Rate this article / item","yet-another-stars-rating"),a=wp.data.select("core/editor").getCurrentPost().meta.yasr_overall_rating,r=function(e,t){e=e.toFixed(1),e=parseFloat(e),wp.data.dispatch("core/editor").editPost({meta:{yasr_overall_rating:e}}),this.setRating(e),t()};return React.createElement("div",{className:"yasr-guten-block-panel yasr-guten-block-panel-center"},t,React.createElement("div",{id:"overall-rater",ref:function(){return function(e,t){var a,r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:.1,n=!(arguments.length>4&&void 0!==arguments[4])||arguments[4],l=arguments.length>5&&void 0!==arguments[5]&&arguments[5],s=arguments.length>6&&void 0!==arguments[6]&&arguments[6];a=arguments.length>2&&void 0!==arguments[2]&&arguments[2]||document.getElementById(t),e=parseInt(e),raterJs({starSize:e,showToolTip:!1,element:a,step:r,readOnly:n,rating:l,rateCallback:s})}(32,"overall-rater",!1,.1,!1,a,r)}}))}}},c={};function i(e){var t=c[e];if(void 0!==t)return t.exports;var a=c[e]={exports:{}};return o[e](a,a.exports,i),a.exports}i.d=(e,t)=>{for(var a in t)i.o(t,a)&&!i.o(e,a)&&Object.defineProperty(e,a,{enumerable:!0,get:t[a]})},i.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),i.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},e=i(245),t=wp.blocks.registerBlockType,a=wp.components.PanelBody,r=wp.element.Fragment,n=wp.blockEditor,l=n.useBlockProps,s=n.InspectorControls,t("yet-another-stars-rating/overall-rating-ranking",{edit:function(t){var n=l({className:"yasr-ov-ranking-block"}),o=[React.createElement(e.YasrNoSettingsPanel,{key:0})];function c(e){return React.createElement(s,null,React.createElement(a,{title:"Settings"},React.createElement("div",{className:"yasr-guten-block-panel"},React.createElement("div",null,o))))}return wp.hooks.doAction("yasr_overall_rating_rankings",o),React.createElement(r,null,React.createElement(c,null),React.createElement("div",n,"[yasr_ov_ranking]"))},save:function(e){var t=l.save({className:"yasr-ov-ranking-block"});return React.createElement("div",t,"[yasr_ov_ranking]")}}),t("yet-another-stars-rating/visitor-votes-ranking",{edit:function(t){var n=l({className:"yasr-vv-ranking-block"}),o=[React.createElement(e.YasrNoSettingsPanel,{key:0})];function c(e){return React.createElement(s,null,React.createElement(a,{title:"Settings"},React.createElement("div",{className:"yasr-guten-block-panel"},React.createElement("div",null,o))))}return wp.hooks.doAction("yasr_visitor_votes_rankings",o),React.createElement(r,null,React.createElement(c,null),React.createElement("div",n,"[yasr_most_or_highest_rated_posts]"))},save:function(e){var t=l.save({className:"yasr-vv-ranking-block"});return React.createElement("div",t,"[yasr_most_or_highest_rated_posts]")}})})();