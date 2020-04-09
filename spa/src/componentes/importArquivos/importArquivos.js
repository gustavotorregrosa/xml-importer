import React, { Component } from 'react'
import DropUpload from './dropUpload/dropUpload'
import M from 'materialize-css'

class ImportArquivos extends Component {


    funcaoTrataArquivo = (arquivo) => {

        arquivo.forEach(arq => {
            const formData = new FormData()
            formData.append('arquivos', arq)
            const options = {
                method: 'POST',
                body: formData,
            }
    
            let request = new Request('http://api-xmlconverter.gustavotorregrosa.com/fileupload', options)
    
            fetch(request).then(r => r.json()).then(r =>  Array.from(r.mensagem).forEach(m =>   M.toast({ html: m })))
        })

      
          
    }


    render() {
        return (
            <div>
                <h6>Import de arquivos</h6>
                <br/><br/>
                <DropUpload envioArquivo={(arq) => this.funcaoTrataArquivo(arq)} />
            </div>
           
        )
    }

}

export default ImportArquivos