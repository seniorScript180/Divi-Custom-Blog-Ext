// External Dependencies
import React, { Component } from 'react';

// Internal Dependencies
import './style.css';

class LangShortcodes extends Component {

  static slug = 'cbr_lang_shortcodes';

  render() {   

    return (
      <div dangerouslySetInnerHTML={{__html: this.props.__minutes}} />
    );

  }
}

export default LangShortcodes;