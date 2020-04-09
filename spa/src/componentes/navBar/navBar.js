import React, { Component } from 'react'
import M from 'materialize-css'


class NavBar extends Component {
    
    redirecionar = (e, path) => {
        e.preventDefault()
       this.props.history.push(path)
    }

    limparBanco = e => {
        e.preventDefault()
        const request = new Request('http://api-xmlconverter.gustavotorregrosa.com/limpabanco')
        fetch(request).then(r => r.text()).then(m => M.toast({ html: m }))
        this.redirecionar(e, "/")

    }

    render() {
        return (
            <nav className="black">
                <div className="nav-wrapper">
                    <a onClick={(e) => this.redirecionar(e, '/')} href="#" className="brand-logo">XML Importer</a>
                    <ul id="nav-mobile" className="right hide-on-med-and-down">
                       <li><a onClick={(e) => this.redirecionar(e, '/importar-arquivo')} href="#">Import de XML</a></li>
                       <li><a onClick={(e) => this.limparBanco(e)} href="#">Limpar banco</a></li>
                       <li><a onClick={(e) => this.redirecionar(e, '/pessoas')} href="#">Relatório Pessoas</a></li>
                       <li><a onClick={(e) => this.redirecionar(e, '/ordens')} href="#">Relatório Ordens</a></li>
                    </ul>
                </div>
            </nav>

        )
    }


}

export default NavBar