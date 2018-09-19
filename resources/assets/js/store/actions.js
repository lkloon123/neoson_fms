const resetState = ({commit}) => {
    commit('user/resetStateData');
    commit('twofactor/resetStateData');
    commit('farm/resetStateData');
    commit('miner/resetStateData');
};

export {
    resetState
}