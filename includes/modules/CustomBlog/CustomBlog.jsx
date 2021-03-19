// External Dependencies
import React, { Component } from 'react';
//import $ from 'jquery';

// Internal Dependencies
import './style.css';


class CBRCustomBlog extends Component {

  static slug = 'cbr_custom_blog';

  static css(props) {
    var css = [];

    css.push([{
      selector: "%%order_class%% .et_overlay",
      declaration: `background: ${props.hover_overlay_color}`,
    }]);

    css.push([{
      selector: "%%order_class%% .et_overlay:before",
      declaration: `color: ${props.overlay_icon_color}`,
    }]);

    return css;
  }

  
  render() {

 

    return (
        <div dangerouslySetInnerHTML={{__html: this.props.__posts}} />
    );
  }
}

export default CBRCustomBlog;