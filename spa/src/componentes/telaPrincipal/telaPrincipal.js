import React, { Component } from 'react'
import { Route, BrowserRouter, Switch, withRouter, Redirect } from 'react-router-dom'
import 'materialize-css/dist/css/materialize.min.css'
import M from 'materialize-css'
import NavBar from '../navBar/navBar'
import ImportArquivos from '../importArquivos/importArquivos'
import Logo from './logo'

class TelaPrincipal extends Component {

    render() {
        return <Logo />    
    }


}

export default TelaPrincipal