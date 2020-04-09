import React from 'react'
import xmlLogo from '../../assets/xmllogo.png'

const myStyle = {
    display: 'block',
    marginLeft: 'auto',
    marginRight: 'auto',
    width: '20em'
  }

const Logo = () => (
    <div>
        <img src={xmlLogo} style={myStyle}/>
    </div>
)

export default Logo