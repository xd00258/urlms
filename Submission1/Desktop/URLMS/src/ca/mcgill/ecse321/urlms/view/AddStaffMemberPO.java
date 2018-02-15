package ca.mcgill.ecse321.urlms.view;

import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.border.EmptyBorder;

import ca.mcgill.ecse321.urlms.controller.InvalidInputException;
import ca.mcgill.ecse321.urlms.controller.StaffController;

import javax.swing.GroupLayout;
import javax.swing.GroupLayout.Alignment;
import javax.swing.JTextField;
import javax.swing.JCheckBox;
import javax.swing.LayoutStyle.ComponentPlacement;
import javax.swing.JButton;
import java.awt.event.ActionListener;
import java.awt.event.ActionEvent;
import javax.swing.SwingConstants;
import java.awt.Component;
import javax.swing.JLabel;
import javax.swing.JScrollPane;

public class AddStaffMemberPO extends JFrame {

	private String error;
	
	private JPanel contentPane;
	private JTextField txtName;
	public static StaffController controller = new StaffController();
	
	private JCheckBox ResearchAssistantBox = new JCheckBox("Research Assistant");
	private JCheckBox ResearchAssociateBox = new JCheckBox("Research Associate");
	private JTextField txtSalary;
	
	private JLabel lblError;
	private JLabel lblSalary;
	private JLabel lblName;
	private JButton btnClose;
	private JButton addButton;


	/**
	 * Create the frame.
	 */
	public AddStaffMemberPO() {
		initComponents();
	}
	
	private void initComponents(){
		setResizable(false);
		setAlwaysOnTop(true);
		setTitle("Add Staff Member");
		setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
		setBounds(100, 100, 568, 320);
		contentPane = new JPanel();
		contentPane.setBorder(new EmptyBorder(5, 5, 5, 5));
		setContentPane(contentPane);
		
		txtName = new JTextField();
		txtName.setColumns(10);
		

		
		addButton = new JButton("Add to List");
		addButton.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				error = "";
				
				String staffMemberName = txtName.getText();
				boolean box1 = ResearchAssistantBox.isSelected();
				boolean box2 = ResearchAssociateBox.isSelected();
				
				String stringSalary = txtSalary.getText();
				if(stringSalary.toLowerCase().trim().equals("celery")){
					error += "Nice try with the celery. ";
				}
				double doubleSalary;
				try {
					doubleSalary = Double.valueOf(stringSalary);
				} catch (RuntimeException e2) {
					doubleSalary = -1;
				}
				
				try {
					controller.addStaffMember(staffMemberName, box1, box2, doubleSalary);
				} catch (InvalidInputException e1) {
					error += e1.getMessage();
				}
				refreshData();
			}
		});
		
		txtSalary = new JTextField();
		txtSalary.setColumns(10);
		
		btnClose = new JButton("Close");
		btnClose.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				close();
			}
		});
		
		lblName = new JLabel("Name:");
		
		lblSalary = new JLabel("Salary:");
		
		JScrollPane scrollPane = new JScrollPane();
		GroupLayout gl_contentPane = new GroupLayout(contentPane);
		gl_contentPane.setHorizontalGroup(
			gl_contentPane.createParallelGroup(Alignment.LEADING)
				.addGroup(gl_contentPane.createSequentialGroup()
					.addGap(42)
					.addComponent(scrollPane, GroupLayout.DEFAULT_SIZE, 479, Short.MAX_VALUE)
					.addGap(31))
				.addGroup(gl_contentPane.createSequentialGroup()
					.addGap(187)
					.addComponent(addButton)
					.addPreferredGap(ComponentPlacement.RELATED)
					.addComponent(btnClose)
					.addGap(176))
				.addGroup(gl_contentPane.createSequentialGroup()
					.addGap(198)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.LEADING)
						.addComponent(ResearchAssistantBox)
						.addComponent(ResearchAssociateBox))
					.addGap(187))
				.addGroup(Alignment.TRAILING, gl_contentPane.createSequentialGroup()
					.addContainerGap(181, Short.MAX_VALUE)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.LEADING)
						.addGroup(Alignment.TRAILING, gl_contentPane.createSequentialGroup()
							.addComponent(lblName)
							.addPreferredGap(ComponentPlacement.RELATED)
							.addComponent(txtName, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE))
						.addGroup(Alignment.TRAILING, gl_contentPane.createSequentialGroup()
							.addComponent(lblSalary)
							.addPreferredGap(ComponentPlacement.RELATED)
							.addComponent(txtSalary, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)))
					.addGap(170))
		);
		gl_contentPane.setVerticalGroup(
			gl_contentPane.createParallelGroup(Alignment.LEADING)
				.addGroup(Alignment.TRAILING, gl_contentPane.createSequentialGroup()
					.addContainerGap(41, Short.MAX_VALUE)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(txtName, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
						.addComponent(lblName))
					.addPreferredGap(ComponentPlacement.RELATED)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(txtSalary, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
						.addComponent(lblSalary))
					.addPreferredGap(ComponentPlacement.RELATED)
					.addComponent(ResearchAssistantBox)
					.addPreferredGap(ComponentPlacement.RELATED)
					.addComponent(ResearchAssociateBox)
					.addPreferredGap(ComponentPlacement.RELATED)
					.addComponent(scrollPane, GroupLayout.PREFERRED_SIZE, 46, GroupLayout.PREFERRED_SIZE)
					.addPreferredGap(ComponentPlacement.RELATED)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(addButton)
						.addComponent(btnClose))
					.addContainerGap())
		);
		gl_contentPane.linkSize(SwingConstants.HORIZONTAL, new Component[] {ResearchAssistantBox, ResearchAssociateBox});
		
		lblError = new JLabel("Please add some members if you wanna.");
		scrollPane.setViewportView(lblError);
		contentPane.setLayout(gl_contentPane);
	}
	
	private void refreshData(){
		if(error.length() > 0){
			lblError.setText(error);
		}
		else{
			lblError.setText("Staff member successfully added.");
		}
	}
	
	public void close() { 
		this.setVisible(false);
	    this.dispose();
	}
}
