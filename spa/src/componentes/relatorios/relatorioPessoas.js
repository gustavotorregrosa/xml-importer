import React, { Component } from 'react'

class RelatorioPessoas extends Component {


    constructor(props) {
        super(props)
        this.state = {
            pessoas: ""
        }

    }

    componentDidMount() {
        const request = new Request('http://api-xmlconverter.gustavotorregrosa.com/pessoas')
        fetch(request).then(r => r.json()).then(r => {
            let pessoas = ""
            r.forEach(p => {
                pessoas += JSON.stringify(p)
            });

            this.setState({
                pessoas
            })
        })
    }



    render() {
        return (
            <div>
                <h6>Relatorio pessoas...</h6>
                {this.state.pessoas}
            </div>

        )
    }

}

export default RelatorioPessoas