import React, {useEffect, useState} from 'react';
import {useParams, useHistory} from "react-router-dom";
import useFetch from "../utils/useFetch";

const TodoEdit = () => {
    const {id} = useParams();
    const {data: todo, error, isLoading} = useFetch('/api/tasks/' + id);
    const [description, setDescription] = useState('')
    const [completedAt, setCompletedAt] = useState('')
    const history = useHistory();
    const editedTodo = {description, completedAt};
    const {executeFetch} = useFetch(
        '/api/tasks/' + id,
        {method: 'PATCH', body: JSON.stringify(editedTodo)},
        {immediate: false}
    );

    useEffect(() => {
        if (todo) {
            setDescription(todo.description);
            setCompletedAt(todo.completedAt);
        }
    }, [todo]);

    const handleSubmit = (e) => {
        e.preventDefault();
        executeFetch().then(() => {
            history.push('/');
        });
    }

    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-5">
                    {error && <div>{error}</div>}
                    {isLoading && <div>Loading...</div>}
                    {todo &&
                        <form onSubmit={handleSubmit} method="post">
                            <h2 className="text-center">Edit todo</h2>
                            {error && <div className="text-danger">{error}</div>}
                                <div className="form-group">
                                    <label htmlFor="description">Description:</label>
                                    <textarea
                                        id="description"
                                        className="form-control"
                                        rows="3"
                                        defaultValue={todo.description}
                                        onChange={(e) => setDescription(e.target.value)}
                                    ></textarea>
                                </div>
                                <div className="form-group">
                                    <label htmlFor="completedAt">Completed at:</label>
                                    <input
                                        id="completedAt"
                                        type="date"
                                        className="form-control"
                                        defaultValue={todo.completedAt || ''}
                                        onChange={(e) => setCompletedAt(e.target.value)}
                                    />
                                </div>
                                <div className="form-group">
                                    {!isLoading && <button type="submit" className="btn btn-primary btn-block">Save</button>}
                                    {isLoading &&
                                    <button type="submit" className="btn btn-primary btn-block" disabled>Save...</button>}
                                </div>
                        </form>
                    }
                </div>
            </div>
        </div>
    );
}

export default TodoEdit
