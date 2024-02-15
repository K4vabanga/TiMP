#include <stdlib.h>
#include <iostream>
#include <string.h>
#include <fstream>
#include <cstring>
#include <cmath>

using namespace std;

int blocker(string a);
int unblocker(string a);
int checer(string a);
int HashFunc(int k);

int main (int argc, char *argv[]) {
	ifstream file("template.tbl");
	if (!file.good()) {
		cout << "Missing 'template.tbl' file!" << endl;
		return 1;
	}
	
	system("chmod ugo-rwx template.tbl");
	system("sudo chattr +i template.tbl");
	
	string s, pswd;
	int key, password;
	string a = "a.tbl";
	
	getline(file, pswd);
	password = atoi(pswd.c_str());
	
	/*while (getline(file, s)) {
		cout << s << endl;
	}*/
	
	if (argc != 2) {
		cout << "Invalid number of parameters!" << endl;
		cout << "Use '-h' switch for help" << endl;
		file.close();
		return 1;
	}
	
	if (strcmp(argv[1], "-n") == 0) {
		while (getline(file, a)) {
			if (checer(a))
				blocker(a);
		}
		cout << "Protection activated" << endl;
		file.close();
		return 0;
	}
	
	if (strcmp(argv[1], "-f") == 0) {
		cout << "Please, enter password" << endl;
		cin >> key;
		if (password == HashFunc(key)) {
			while (getline(file, a)) {
				if (checer(a))
					unblocker(a);
			}
			cout << "Accessed" << endl;
			file.close();
			return 0;
			}
		else {
			cout << "Access denied" << endl;
			file.close();
			return 1;
		}
	}
	
	if (strcmp(argv[1], "-h") == 0) {
		cout << "Use:" << endl;
		cout << "'-h'	for help" << endl;
		cout << "'-n'	to enable protection" << endl;
		cout << "'-f'	to disable protection" << endl;
		file.close();
		return 0;
		}
	else {
		cout << "Invalid argument!" << endl;
		cout << "Use '-h' switch for help" << endl;
		file.close();
		return 1;
	}
}

int blocker(string a) {
	char c[100];
	const char* b1 = "sudo chattr +i ";
	const char* b2 = a.c_str();
	strcpy(c, b1);
	strcat(c, b2);

	system(c);
	return 0;
}

int unblocker(string a) {
	char c[100];
	const char* b1 = "sudo chattr -i ";
	const char* b2 = a.c_str();
	strcpy(c, b1);
	strcat(c, b2);

	system(c);
	return 0;
}

int checer(string a) {
	ifstream f1(a);
	if (!f1.good()) {
		cout << a << " does not exist" << endl;
		f1.close();
		return 0;
		}
	f1.close();
	return 1;
} 

int HashFunc(int k) {
	int n = 1000000000;
	double a = 0.618033988;
	int h = n * fmod (k * a, 1);
	return h;
}
