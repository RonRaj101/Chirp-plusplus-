// method parameter should be a string in the format of a sql datetime string
export default function timeSinceLastChirp(sqlStr) {

    //split sql timezone into constituent parts, remove separators
    var t = sqlStr.split(/[- : T Z]/);
    var newDate = new Date(t[0], t[1]-1, t[2], t[3], t[4],t[5]);

    //get last date when chirp was created
    var lastDate = new Date(newDate.getTime() - (newDate.getTimezoneOffset() * 60000));

    //epoch time difference b/w the chirp and now
    var timeSince = new Date().getTime() - lastDate.getTime();

    //calculate milliseconds in a day
    const dayMillisecs = 1000*60*60*24;
    
    //convert epoch time back to normal time by dividing milliseconds with the number of milliseconds in a day
    return timeSince/dayMillisecs;
}