import React, { Component } from 'react'

class RelatorioOrdens extends Component {

    constructor(props) {
        super(props)
        this.state = {
            ordens: ""
        }

    }

    componentDidMount() {
        const request = new Request('http://api-xmlconverter.gustavotorregrosa.com/ordens')
        fetch(request).then(r => r.json()).then(r => {
            let ordens = ""
            r.forEach(o => {
                ordens += JSON.stringify(o)
            });

            this.setState({
                ordens
            })
        })
    }



    render() {
        return (
            <div>
                <h6>Relatorio ordens...</h6>
                {this.state.ordens}
            </div>

        )
    }


}

export default RelatorioOrdens