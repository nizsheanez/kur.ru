(function (Object) {
    var standard = !!Object.getOwnPropertyDescriptor, nonStandard = !!{}.__defineGetter__;

    if (!standard && !nonStandard) throw new Error('Accessors are not supported');
    
    var lookup = nonStandard ?
        function (from, key) {
            var g = from.__lookupGetter__(key), s = from.__lookupSetter__(key);

            return ( g || s ) ? { get: g, set: s } : null;
        } :
        function (from, key) {
            var descriptor = Object.getOwnPropertyDescriptor(from, key);
            if (!descriptor) {
                var proto = Object.getPrototypeOf(from);
                if (proto) return accessors.lookup(proto, key);
            } else if ( descriptor.set || descriptor.get ) {
                return {
                    set: descriptor.set,
                    get: descriptor.get
                };
            }
            return null;
        };

    var define = nonStandard ?
        function (object, prop, descriptor) {
            if (descriptor) {
                if (descriptor.get) object.__defineGetter__(prop, descriptor.get);
                if (descriptor.set) object.__defineSetter__(prop, descriptor.set);
            }
            return object;
        } :
        function (object, prop, descriptor) {
            if (descriptor) {
                var desc = {
                    get: descriptor.get,
                    set: descriptor.set,
                    configurable: true,
                    enumerable: true
                };
                Object.defineProperty(object, prop, desc);
            }
            return object;
        };
        
    this.accessors = {
        lookup: lookup,
        define: define
    };
})(Object);