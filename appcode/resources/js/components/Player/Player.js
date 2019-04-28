import React, { Component } from 'react';
import Spinner from '../Spinner/Spinner';
import axios from 'axios';
import './Player.css';
import { NO_IMAGE_PATH } from '../config';

class Player extends Component {
	constructor() {
        super();
        
        this.state = {
            players: [],
            loading: false,
            selectedFile: null,
            firstName: '',
            lastName: '',
            teams: [],
            selectedTeam: [],
            id: ''
        }

        this.fileSelectedHandler = this.fileSelectedHandler.bind(this);
        this.playerSaveHandler = this.playerSaveHandler.bind(this);
        this.firstNameHandler = this.firstNameHandler.bind(this);
        this.lastNameHandler = this.lastNameHandler.bind(this);
        this.playerEditHandler = this.playerEditHandler.bind(this);
        this.playerDeleteHandler = this.playerDeleteHandler.bind(this);
        this.selectChangeHandler = this.selectChangeHandler.bind(this);
    }

    componentWillMount() {
    	this.setState({ loading: true })
    	
    	this.bindPlayer();  

        this.bindTeam();  	
    }

    bindPlayer() {
    	axios.get('/player/content').then(response =>  {
            this.setState({
                players: response.data.player,
                loading: false
            });
        }).catch(errors => {
            console.log(errors);
        })
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

    firstNameHandler(event) {
        this.setState({ firstName: event.target.value });
    }

    lastNameHandler(event) {
        this.setState({ lastName: event.target.value });
    }

    fileSelectedHandler(event) {
         this.setState({ selectedFile: event.target.files[0] });
    }

    playerSaveHandler(e) {
        e.preventDefault();
        
        const fd = new FormData();
        fd.append('firstName', this.state.firstName);
        fd.append('lastName', this.state.lastName);
        fd.append('photo', this.state.selectedFile);
        fd.append('playerId', this.state.id);
        fd.append('team', this.state.selectedTeam);
        axios.post('/player', fd).then(response =>  {
            this.setState({
                selectedFile: null,
                firstName: '',
                lastName: '',
                id: '',
                selectedTeam: []
            });

            this.bindTeam();
            this.bindPlayer();
        }).catch(errors => {
            console.log(errors.response.data);
        })
    }

    playerEditHandler(e) {
        e.preventDefault();

        let id = e.target.getAttribute('data-key').split('_')[1];
        
        axios.get('/player/' + id).then(response =>  {
            this.setState({
                id: response.data.data.id,
                firstName: response.data.data.first_name,
                lastName: response.data.data.last_name,
            });
        }).catch(errors => {
            console.log(errors.response.data);
        })
    }

    selectChangeHandler(e) {
        e.preventDefault();
        
        let opts = [], opt;

        for(let i=0, len = e.target.options.length; i < len; i++) {
            opt = e.target.options[i];

            if (opt.selected) {
                opts.push(opt.value);
            }
        }

        this.setState({selectedTeam: opts});
    }

    playerDeleteHandler(e) {
        e.preventDefault();

        let id = e.target.getAttribute('data-key').split('_')[1];
                
        axios.delete('/player/' + id).then(response =>  {
            this.bindPlayer();
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
                            <div className="card-header">Add/Update Player</div>
                            <div className="card-body">
                                <div className="form-group row">
                                    <label className="col-sm-4 col-form-label text-md-right">First Name</label>

                                    <div className="col-md-6">
                                        <input type="text" id="name" onChange={this.firstNameHandler} value={this.state.firstName}/>
                                    </div>
                                </div>
                                <div className="form-group row">
                                    <label className="col-sm-4 col-form-label text-md-right">Last Name</label>

                                    <div className="col-md-6">
                                        <input type="text" id="name" onChange={this.lastNameHandler} value={this.state.lastName}/>
                                    </div>
                                </div>
                                <div className="form-group row">
                                    <label className="col-md-4 col-form-label text-md-right">Photo</label>

                                    <div className="col-md-6">
                                        <input type="file" id="logo" onChange={this.fileSelectedHandler}/>
                                    </div>
                                </div>
                                <div className="form-group row">
                                    <label className="col-md-4 col-form-label text-md-right">Playing for Team</label>

                                    <div className="col-md-6">
                                        <select onBlur={this.selectChangeHandler} multiple={true}>
                                            {this.state.teams.map(team =>
                                                <option key={team.id} value={team.id}>{team.name}</option>
                                            )} 
                                        </select>
                                    </div>
                                </div>
                                <div className="form-group row mb-0">
                                    <div className="col-md-12 offset-md-5">
                                        <button onClick={this.playerSaveHandler} className="btn btn-primary">
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
                            <div className="card-header">Player List</div>
                            <div className="card-body">
                                {this.state.players.map(player => 
                                    <div key={player.id} className="form-group row">
                                        <div className="leftList">
                                            <img src={player.photo_url === null ? `${NO_IMAGE_PATH}` : player.photo_url} className="photo"/>
                                        </div>
                                        <div className="rightList">
                                            <div>
                                                {player.first_name} {player.last_name}
                                            </div>
                                            <div className="actionList">
                                                <button key={'e'+player.id} data-key={'e_' + player.id} onClick={this.playerEditHandler} className="btn btn-info btn-space">Edit</button>
                                                <button key={'d'+player.id} data-key={'d_' + player.id} onClick={this.playerDeleteHandler} className="btn btn-danger btn-space">Delete</button>
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

export default Player;