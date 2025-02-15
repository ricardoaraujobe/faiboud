//@line 38 "/usr/local/src/wine-mozilla/toolkit/components/nsDefaultCLH.js"

const nsISupports              = Components.interfaces.nsISupports;

const nsICategoryManager       = Components.interfaces.nsICategoryManager;
const nsIComponentRegistrar    = Components.interfaces.nsIComponentRegistrar;
const nsICommandLine           = Components.interfaces.nsICommandLine;
const nsICommandLineHandler    = Components.interfaces.nsICommandLineHandler;
const nsIFactory               = Components.interfaces.nsIFactory;
const nsIModule                = Components.interfaces.nsIModule;
const nsIPrefBranch            = Components.interfaces.nsIPrefBranch;
const nsISupportsString        = Components.interfaces.nsISupportsString;
const nsIWindowWatcher         = Components.interfaces.nsIWindowWatcher;
const nsIProperties            = Components.interfaces.nsIProperties;
const nsIFile                  = Components.interfaces.nsIFile;
const nsISimpleEnumerator      = Components.interfaces.nsISimpleEnumerator;

/**
 * This file provides a generic default command-line handler.
 *
 * It opens the chrome window specified by the pref "toolkit.defaultChromeURI"
 * with the flags specified by the pref "toolkit.defaultChromeFeatures"
 * or "chrome,dialog=no,all" is it is not available.
 * The arguments passed to the window are the nsICommandLine instance.
 *
 * It doesn't do anything if the pref "toolkit.defaultChromeURI" is unset.
 */

function getDirectoryService()
{
  return Components.classes["@mozilla.org/file/directory_service;1"]
                   .getService(nsIProperties);
}

var nsDefaultCLH = {
  /* nsISupports */

  QueryInterface : function clh_QI(iid) {
    if (iid.equals(nsICommandLineHandler) ||
        iid.equals(nsIFactory) ||
        iid.equals(nsISupports))
      return this;

    throw Components.results.NS_ERROR_NO_INTERFACE;
  },

  /* nsICommandLineHandler */

  handle : function clh_handle(cmdLine) {
    var printDir;
    while (printDir = cmdLine.handleFlagWithParam("print-xpcom-dir", false)) {
      var out = "print-xpcom-dir(\"" + printDir + "\"): ";
      try {
        out += getDirectoryService().get(printDir, nsIFile).path;
      }
      catch (e) {
        out += "<Not Provided>";
      }

      dump(out + "\n");
      Components.utils.reportError(out);
    }

    var printDirList;
    while (printDirList = cmdLine.handleFlagWithParam("print-xpcom-dirlist",
                                                      false)) {
      out = "print-xpcom-dirlist(\"" + printDirList + "\"): ";
      try {
        var list = getDirectoryService().get(printDirList,
                                             nsISimpleEnumerator);
        while (list.hasMoreElements())
          out += list.getNext().QueryInterface(nsIFile).path + ";";
      }
      catch (e) {
        out += "<Not Provided>";
      }

      dump(out + "\n");
      Components.utils.reportError(out);
    }
    
    if (cmdLine.handleFlag("silent", false)) {
      cmdLine.preventDefault = true;
    }

    if (cmdLine.preventDefault)
      return;

    var prefs = Components.classes["@mozilla.org/preferences-service;1"]
                          .getService(nsIPrefBranch);

    try {
      var singletonWindowType =
                              prefs.getCharPref("toolkit.singletonWindowType");
      var windowMediator =
                Components.classes["@mozilla.org/appshell/window-mediator;1"]
                          .getService(Components.interfaces.nsIWindowMediator);

      var win = windowMediator.getMostRecentWindow(singletonWindowType);
      if (win) {
        win.focus();
    	cmdLine.preventDefault = true;
	  return;
      }
    }
    catch (e) { }

    // if the pref is missing, ignore the exception 
    try {
      var chromeURI = prefs.getCharPref("toolkit.defaultChromeURI");

      var flags = "chrome,dialog=no,all";
      try {
        flags = prefs.getCharPref("toolkit.defaultChromeFeatures");
      }
      catch (e) { }

      var wwatch = Components.classes["@mozilla.org/embedcomp/window-watcher;1"]
                            .getService(nsIWindowWatcher);
      wwatch.openWindow(null, chromeURI, "_blank",
                        flags, cmdLine);
    }
    catch (e) { }
  },

  helpInfo : "",

  /* nsIFactory */

  createInstance : function mdh_CI(outer, iid) {
    if (outer != null)
      throw Components.results.NS_ERROR_NO_AGGREGATION;

    return this.QueryInterface(iid);
  },

  lockFactory : function mdh_lock(lock) {
    /* no-op */
  }
};

const clh_contractID = "@mozilla.org/toolkit/default-clh;1";
const clh_CID = Components.ID("{6ebc941a-f2ff-4d56-b3b6-f7d0b9d73344}");

var Module = {
  /* nsISupports */

  QueryInterface : function mod_QI(iid) {
    if (iid.equals(nsIModule) ||
        iid.equals(nsISupports))
      return this;

    throw Components.results.NS_ERROR_NO_INTERFACE;
  },

  /* nsIModule */

  getClassObject : function mod_gch(compMgr, cid, iid) {
    if (cid.equals(clh_CID))
      return nsDefaultCLH.QueryInterface(iid);

    throw components.results.NS_ERROR_FAILURE;
  },

  registerSelf : function mod_regself(compMgr, fileSpec, location, type) {
    var compReg = compMgr.QueryInterface(nsIComponentRegistrar);

    compReg.registerFactoryLocation(clh_CID,
                                    "nsDefaultCLH",
                                    clh_contractID,
                                    fileSpec,
                                    location,
                                    type);

    var catMan = Components.classes["@mozilla.org/categorymanager;1"]
                           .getService(nsICategoryManager);

    catMan.addCategoryEntry("command-line-handler",
                            "y-default",
                            clh_contractID, true, true);
  },

  unregisterSelf : function mod_unreg(compMgr, location, type) {
    var compReg = compMgr.QueryInterface(nsIComponentRegistrar);
    compReg.unregisterFactoryLocation(clh_CID, location);

    var catMan = Components.classes["@mozilla.org/categorymanager;1"]
                           .getService(nsICategoryManager);

    catMan.deleteCategoryEntry("command-line-handler",
                               "y-default");
  },

  canUnload : function (compMgr) {
    return true;
  }
};

function NSGetModule(compMgr, fileSpec) {
  return Module;
}
