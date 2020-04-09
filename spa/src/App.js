import React from 'react';
// import logo from './logo.svg';
// import './App.css';
import { Route, Router, BrowserRouter, Switch, withRouter, Redirect } from 'react-router-dom'
import 'materialize-css/dist/css/materialize.min.css'
import M from 'materialize-css'
import TelaPrincipal from './componentes/telaPrincipal/telaPrincipal'
import ImportArquivos from './componentes/importArquivos/importArquivos'
import RelatorioPessoas from './componentes/relatorios/relatorioPessoas';
import RelatorioOrdens from './componentes/relatorios/relatorioOrdens';
import NavBar from './componentes/navBar/navBar'
import history from './suporte/history'

function App() {
  return (

    <div>
      <NavBar history={history} />
      <br /><br /><br />
      <div className="container">
        <div className="row">
          <Switch>
            <Router history={history} >
              <Route path='/importar-arquivo' component={ImportArquivos} />
              <Route path='/pessoas' component={RelatorioPessoas} />
              <Route path='/ordens' component={RelatorioOrdens} />
              <Route path='/' exact component={TelaPrincipal} />
            </Router>
          </Switch>
        </div>
      </div>

    </div>


  )
}

export default withRouter(App);
