import '../node_modules/bootstrap/dist/css/bootstrap.min.css';

import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Route, Switch, Link } from "react-router-dom";
import Home from './components/Home';
import Login from "./components/Login";
import TodoDetails from "./components/TodoDetails";
import TodoCreate from "./components/TodoCreate";
import PageNotFound from "./components/PageNotFound";
import Register from "./components/Register";
import TodoEdit from "./components/TodoEdit";
import NavBar from "./components/NavBar";

ReactDOM.render(
    <div className="bg-dark text-white" style={{minHeight : '100vh'}}>
        <Router>
            <NavBar />
            <Switch>
                <Route exact path="/">
                    <Home />
                </Route>
                <Route path="/register">
                    <Register />
                </Route>
                <Route path="/login">
                    <Login />
                </Route>
                <Route exact path="/todos">
                    <TodoCreate />
                </Route>
                <Route exact path="/todos/:id">
                    <TodoDetails />
                </Route>
                <Route path="/todos/:id/edit">
                    <TodoEdit />
                </Route>
                <Route path="*">
                    <PageNotFound />
                </Route>
            </Switch>
        </Router>
    </div>,
    document.getElementById('root')
);
