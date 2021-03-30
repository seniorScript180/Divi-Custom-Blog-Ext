// External Dependencies
import React, { Component } from 'react';

// Internal Dependencies
import './style.css';

class ReadingEstimate extends Component {

  static slug = 'cbr_reading_estimate';

  static css(props) {
    var css = [];

    css.push([{
      selector: ".cbr-icon .icon",
      declaration: `fill: ${props.icon_color}`,
    }]);

    return css;
  }

  render() {   

    return (
      <div dangerouslySetInnerHTML={{__html: this.props.__minutes}} />
    );

  }
}

export default ReadingEstimate;
