import React, { Component } from 'react';
import Spinner from '../Spinner/Spinner';
import axios from 'axios';
import './Team.css';
import { NO_IMAGE_PATH } from '../config';

class Team extends Component {
	constructor() {
        super();
        
        this.state = {
            teams: [],
            loading: false,
            selectedFile: null,
            name: '',
            id: ''
        }

        this.fileSelectedHandler = this.fileSelectedHandler.bind(this);
        this.teamSaveHandler = this.teamSaveHandler.bind(this);
        this.teamHandler = this.teamHandler.bind(this);
        this.teamEditHandler = this.teamEditHandler.bind(this);
        this.teamDeleteHandler = this.teamDeleteHandler.bind(this);
    }

    componentWillMount() {
    	this.setState({ loading: true })
    	
    	this.bindTeam();
    }

    bindTeam() {
    	axios.get('/team/content').then(response =>  {
            this.setState({
                teams: response.data.team,
                loading: false
            });
        }).catch(errors => {
            console.log(errors);
        })
    }

    teamHandler(event) {
        this.setState({ name: event.target.value });
    }

    fileSelectedHandler(event) {
         this.setState({ selectedFile: event.target.files[0] });
    }

    teamSaveHandler(e) {
        e.preventDefault();
        
        const fd = new FormData();
        fd.append('teamName', this.state.name);
        fd.append('teamLogo', this.state.selectedFile);
        fd.append('teamId', this.state.id);

        axios.post('/team', fd).then(response =>  {
            console.log(response.data);
            this.setState({
                selectedFile: null,
                name: '',
                id: ''
            });

            this.bindTeam();
        }).catch(errors => {
            console.log(errors.response.data);
        })
    }

    teamEditHandler(e) {
        e.preventDefault();

        let id = e.target.getAttribute('data-key').split('_')[1];

        axios.get('/team/' + id).then(response =>  {
            this.setState({
                id: response.data.data.id,
                name: response.data.data.name
            });
        }).catch(errors => {
            console.log(errors.response.data);
        })
    }

    teamDeleteHandler(e) {
        e.preventDefault();

        let id = e.target.getAttribute('data-key').split('_')[1];
        
        axios.delete('/team/' + id).then(response =>  {
            this.bindTeam();
        }).catch(errors => {
            console.log(errors.response.data);
        })
    }

    render() {
        return (
            <React.Fragment>
                <div className="row justify-content-center">
                    <div className="col-md-6">
                        <div className="card">
                            <div className="card-header">Add/Update Team</div>
                            <div className="card-body">
                                <div className="form-group row">
                                    <label className="col-sm-4 col-form-label text-md-right">Name</label>

                                    <div className="col-md-6">
                                        <input type="text" id="name" onChange={this.teamHandler} value={this.state.name}/>
                                    </div>
                                </div>
                                <div className="form-group row">
                                    <label className="col-md-4 col-form-label text-md-right">Logo</label>

                                    <div className="col-md-6">
                                        <input type="file" id="logo" onChange={this.fileSelectedHandler}/>
                                    </div>
                                </div>
                                <div className="form-group row mb-0">
                                    <div className="col-md-12 offset-md-5">
                                        <button onClick={this.teamSaveHandler} className="btn btn-primary">
                                            Save
                                        </button>
                                        <input type="hidden" value={this.state.id} id="editId" readOnly/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col-md-6">
                        <div className="card">
                            <div className="card-header">Team List</div>
                            <div className="card-body">
                                {this.state.teams.map(team => 
                                    <div key={team.id} className="form-group row">
                                        <div className="leftList">
                                            <img src={team.logo_url === null ? `${NO_IMAGE_PATH}` : team.logo_url} className="photo"/>
                                        </div>
                                        <div className="rightList">
                                            <div>
                                                {team.name}
                                            </div>
                                            <div className="actionList">
                                                <button key={'e'+team.id} data-key={'e_' + team.id} onClick={this.teamEditHandler} className="btn btn-info btn-space">Edit</button>
                                                <button key={'d'+team.id} data-key={'d_' + team.id} onClick={this.teamDeleteHandler} className="btn btn-danger btn-space">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </React.Fragment>
        );
    }
}

export default Team;