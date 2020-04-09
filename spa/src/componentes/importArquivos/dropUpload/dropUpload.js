import React, { Component } from 'react';
import Dropzone from 'react-dropzone'

class DropUpload extends Component {


  onDrop = (acceptedFiles) => {
    // console.log(acceptedFiles);
    this.props.envioArquivo(acceptedFiles)
  }

  render() {
    const estilos = {
        backgroundColor: 'lightblue',
        minHeight: '20em',
        border: '2px solid darkblue',
        borderRadius: '1em'
    }

    return (
      <div className="text-center mt-5">
        <Dropzone onDrop={this.onDrop}>
          {({getRootProps, getInputProps}) => (
            <div {...getRootProps()} style={estilos}>
              <input {...getInputProps()} />
              <h6>
                  Arraste e solte o arquivo...
                </h6> 
            </div>
          )}
        </Dropzone>
      </div>
    );
  }
}

export default DropUpload;