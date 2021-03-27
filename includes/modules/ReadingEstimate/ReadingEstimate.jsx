// External Dependencies
import React, { Component } from 'react';

// Internal Dependencies
import './style.css';

class ReadingEstimate extends Component {

  static slug = 'cbr_reading_estimate';

  render() {

    console.log(this.props);

    let tmp = this.props.__minutes;

    return (
      <div dangerouslySetInnerHTML={{__html: this.props.__minutes}} />
    );

  }
}

export default ReadingEstimate;
